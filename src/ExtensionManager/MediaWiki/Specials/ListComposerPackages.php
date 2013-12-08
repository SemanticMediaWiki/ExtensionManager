<?php

namespace ExtensionManager\MediaWiki\Specials;

use ExtensionManager\DIC\ServiceAccess;
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

		$reader = ServiceAccess::getInstance()->newPackageTableBuilder( $this->getContext() );

		$this->getOutput()->addWikiText( $reader->getText() );
	}

	/**
	 * TODO: use
	 */
	protected function canNotRead( $reader ) {
		return $this->msg( 'composerpackages-file-not-available', $reader->getFileName() );
	}

}
