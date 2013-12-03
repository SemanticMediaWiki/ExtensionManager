<?php

namespace ComposerPackages\Specials;

use ServiceRegistry\ServiceRegistry;

/**
 * Implements Special:ListComposerPackages
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class ListComposerPackages extends \SpecialPage {

	/**
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'ListComposerPackages' );
	}

	/**
	 * @since 0.1
	 */
	public function execute( $par ) {

		$this->setHeaders();

		$reader = ServiceRegistry::getInstance( 'composerpackages' )->newObject( 'FileReader' );

		$this->getOutput()->addWikiText(
			$reader->canReadFile() ? $this->buildText() : $this->canNotRead( $reader )
		);

	}

	/**
	 * @since 0.1
	 */
	protected function buildText() {

		$builder = ServiceRegistry::getInstance( 'composerpackages' )->newObject( 'TextBuilder', array(
			'RequestContext' => $this->getContext()
		) );

		return $builder->getText();
	}

	/**
	 * @since 0.1
	 */
	protected function canNotRead( $reader ) {
		return $this->msg( 'composerpackages-file-not-available', $reader->getFileName() );
	}

}
