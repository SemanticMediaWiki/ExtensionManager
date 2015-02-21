<?php

namespace ExtensionManager\MediaWiki\Specials;

use ExtensionManager\ServiceAccess;

/**
 * Implements Special:ListComposerPackages
 *
 * @licence GNU GPL v2+
 * @author mwjames
 */
class ListComposerPackages extends \SpecialPage {

	public function __construct() {
		parent::__construct( 'ListComposerPackages' );
	}

	public function execute( $par ) {
		$this->setHeaders();

		$reader = ServiceAccess::getInstance()->newPackageTableBuilder( $this->getContext() );

		$this->getOutput()->addWikiText( $reader->getText() );
	}

	/**
	 * TODO: use
	 */
	private function canNotRead( $reader ) {
		return $this->msg( 'composerpackages-file-not-available', $reader->getFileName() );
	}

}
