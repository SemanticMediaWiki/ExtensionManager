<?php

namespace ComposerPackages;

use InvalidArgumentException;

/**
 * Provides mapping of array elements to composer keys
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class ArrayMapper {

	/** @var array */
	protected $contents = null;

	/**
	 * Internal mapping to external reference key used by the
	 * composer library
	 *
	 * @var array
	 */
	protected $composerKey = array(
		'packages' => 'packages',
		'name'     => 'name',
		'version'  => 'version',
		'time'     => 'time',
		'require'  => 'require',
		'type'     => 'type'
  	);

	/**
	 * @since 0.1
	 *
	 * @param array $contents
	 */
	public function __construct( array $contents ) {
		$this->contents = $contents;
	}

	/**
	 * @since 0.1
	 *
	 * @return mixed
	 */
	public function getElement( $elementName, $package ) {
		return $this->getArrayElement( $this->getExtenalKey( $elementName ), $package );
	}

	/**
	 * @since 0.1
	 *
	 * @return array
	 */
	public function getPackages() {
		return $this->getElement( 'packages', $this->contents );
	}

	/**
	 * @since 0.1
	 *
	 * @return array|null
	 */
	public function findPackage( $name ) {

		foreach ( $this->getPackages() as $package ) {
			if ( $this->getElement( 'name', $package ) === $name ) {
				return $package;
			}
		}

		return null;
	}

	/**
	 * @since 0.1
	 */
	protected function hasArrayElement( $elementName, $element ) {

		if ( isset( $element[ $elementName ] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @since 0.1
	 */
	protected function getArrayElement( $elementName, $element ) {

		if ( $this->hasArrayElement( $elementName, $element ) ) {
			return $element[ $elementName ];
		}

		return null;
	}

	/**
	 * @since 0.1
	 */
	protected function getExtenalKey( $key ) {

		if ( !$this->hasArrayElement( $key, $this->composerKey ) ) {
			throw new InvalidArgumentException( 'Element is can not be mapped or is unknown' );
		}

		return $this->getArrayElement( $key, $this->composerKey );
	}

}
