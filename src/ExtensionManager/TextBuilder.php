<?php

namespace ExtensionManager;

use i18n\MessageBuilder;

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
	 * @param ComposerContentMapper $mapper
	 * @param MessageBuilder $messageBuilder
	 * @param HtmlFormatter $htmlFormatter
	 */
	public function __construct( ComposerContentMapper $mapper, MessageBuilder $messageBuilder, HtmlFormatter $htmlFormatter ) {
		$this->mapper = $mapper;
		$this->messageBuilder = $messageBuilder;
		$this->htmlFormatter = $htmlFormatter;
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
		return $this->messageBuilder->msgText( 'composerpackages-intro' );
	}

	/**
	 * @since 0.1
	 */
	protected function getTableSection() {
		return $this->htmlFormatter->createElement( 'h2', $this->messageBuilder->msgText( 'composerpackages-table-header' ) );
	}

	/**
	 * @since 0.1
	 */
	protected function getTable() {
		return $this->htmlFormatter->createElement(
			'table',
			$this->createTableContent(),
			array( 'class' => 'wikitable sortable', 'width' => '100%' )
		);
	}

	/**
	 * @since 0.1
	 */
	protected function createTableContent() {
		$out = '';

		$out .= $this->htmlFormatter->createElement( 'tr',
			$this->buildHeaderHtml( 'package' ) .
			$this->buildHeaderHtml( 'type' ) .
			$this->buildHeaderHtml( 'version' ) .
			$this->buildHeaderHtml( 'time' ) .
			$this->buildHeaderHtml( 'dependencies' )
		);

		foreach ( $this->mapper->getPackages() as $package ) {
			$out .= $this->htmlFormatter->createElement( 'tr',
				$this->buildCellHtml( $this->mapper->getElement( 'name', $package ) ) .
				$this->buildCellHtml( $this->mapper->getElement( 'type', $package ) ) .
				$this->buildCellHtml( $this->mapper->getElement( 'version', $package ) ) .
				$this->buildCellHtml( $this->mapper->getElement( 'time', $package ) ) .
				$this->buildCellHtml( $this->createDependencyList( $this->mapper->getElement( 'require', $package ) ) )
			);
		}

		return $out;
	}

	private function buildHeaderHtml( $headerName ) {
		return $this->htmlFormatter->createElement(
			'th',
			$this->messageBuilder->msgText( 'composerpackages-table-header-' . $headerName )
		);
	}

	private function buildCellHtml( $htmlContents ) {
		return $this->htmlFormatter->createElement(
			'td',
			$htmlContents
		);
	}

	/**
	 * @since 0.1
	 */
	protected function createDependencyList( $require ) {
		$out = '';

		if ( is_array( $require ) ) {
			$out .=  '<li>' . implode( '</li><li>', array_keys( $require ) ) . '</li>';
		}

		return $out;
	}

}