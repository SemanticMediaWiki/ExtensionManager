<?php

namespace ComposerPackages;

use Html;

/**
 * Class responsible for building a text output
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class TextBuilder {

	/**
	 * @since 0.1
	 *
	 * @param ArrayMapper $mapper
	 * @param MessageBuilder $messageBuilder
	 */
	public function __construct( ArrayMapper $mapper, MessageBuilder $messageBuilder ) {
		$this->mapper = $mapper;
		$this->messageBuilder = $messageBuilder;
	}

	/**
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getText() {
		return $this->getInfo() . $this->getTableSection() . $this->getTable();
	}

	/**
	 * @since 0.1
	 */
	protected function getInfo() {
		return $this->messageBuilder->getText( 'composerpackages-intro' );
	}

	/**
	 * @since 0.1
	 */
	protected function getTableSection() {
		return $this->createElement( 'h2', $this->messageBuilder->getText( 'composerpackages-table-header' ) );
	}

	/**
	 * @since 0.1
	 */
	protected function getTable() {

		$out = '';

		$out .= Html::openElement( 'table', array( 'class' => 'wikitable sortable', 'width' => '100%' ) ) .
				Html::openElement( 'tr' ) .
					$this->createElement( 'th', $this->messageBuilder->getText( 'composerpackages-table-header-package' ) ) .
					$this->createElement( 'th', $this->messageBuilder->getText( 'composerpackages-table-header-type' ) ) .
					$this->createElement( 'th', $this->messageBuilder->getText( 'composerpackages-table-header-version' ) ) .
					$this->createElement( 'th', $this->messageBuilder->getText( 'composerpackages-table-header-time' ) ) .
					$this->createElement( 'th', $this->messageBuilder->getText( 'composerpackages-table-header-dependencies' ) ) .
				Html::closeElement( 'tr' );

		foreach ( $this->mapper->getPackages() as $package ) {
			$out .= Html::openElement( 'tr' ) .
					$this->createElement( 'td', $this->mapper->getElement( 'name', $package ) ) .
					$this->createElement( 'td', $this->mapper->getElement( 'type', $package ) ) .
					$this->createElement( 'td', $this->mapper->getElement( 'version', $package ) ) .
					$this->createElement( 'td', $this->mapper->getElement( 'time', $package ) ) .
					$this->createElement( 'td', $this->getPackageDependencies( $this->mapper->getElement( 'require', $package ) ) ) .
					Html::closeElement( 'tr' );
		}

		return $out . Html::closeElement( 'table' );

	}

	/**
	 * @since 0.1
	 */
	protected function createElement( $type, $text ) {
		return Html::rawElement( $type, array(), $text );
	}

	/**
	 * @since 0.1
	 */
	protected function getPackageDependencies( $require ) {

		$out = '';

		if ( is_array( $require ) ) {
			$out .=  '<li>' . implode( '</li><li>', array_keys( $require ) ) . '</li>';
		}

		return $out;
	}

}