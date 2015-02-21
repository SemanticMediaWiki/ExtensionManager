<?php

namespace ExtensionManager;

use InvalidArgumentException;

/**
 * Provides mapping of array elements to composer keys
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class ComposerContentMapper {

	/** @var array */
	private $fileReader = null;

	/**
	 * Internal mapping to external reference key used by the
	 * composer library
	 *
	 * @var array
	 */
	private $composerKeyMapping = array(
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
	 * @param JsonFileReader $fileReader
	 */
	public function __construct( JsonFileReader $fileReader ) {
		$this->fileReader = $fileReader;
	}

	/**
	 * @since 0.1
	 *
	 * @return mixed
	 */
	public function getElement( $elementName, $package ) {
		return $this->getArrayElement( $this->getComposerKey( $elementName ), $package );
	}

	/**
	 * @since 0.1
	 *
	 * @return array
	 */
	public function getPackages() {
		return $this->getElement( 'packages', $this->fileReader->decodeJsonFile() );
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

	private function hasArrayElement( $elementName, $element ) {
		return isset( $element[ $elementName ] );
	}

	private function getArrayElement( $elementName, $element ) {
		if ( $this->hasArrayElement( $elementName, $element ) ) {
			return $element[ $elementName ];
		}

		return null;
	}

	private function getComposerKey( $key ) {
		if ( !$this->hasArrayElement( $key, $this->composerKeyMapping ) ) {
			throw new InvalidArgumentException( "Element {$key} can not be mapped or is unknown" );
		}

		return $this->getArrayElement( $key, $this->composerKeyMapping );
	}

}
