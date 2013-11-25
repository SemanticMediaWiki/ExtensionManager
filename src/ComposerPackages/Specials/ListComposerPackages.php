<?php

namespace ComposerPackages\Specials;

use ComposerPackages\PackagesFile;
use ComposerPackages\PackagesFileReader;
use ComposerPackages\ArrayMapper;
use ComposerPackages\TextBuilder;
use ComposerPackages\MessageBuilder;

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

		$reader = new PackagesFileReader( new PackagesFile() );

		$this->getOutput()->addWikiText(
			$reader->canReadFile() ? $this->canRead( $reader ) : $this->canNotRead( $reader )
		);

	}

	/**
	 * @since 0.1
	 */
	protected function canRead( $reader ) {

		$mapper  = new ArrayMapper( $reader->decodeJsonFile() );
		$builder = new TextBuilder( $mapper, new MessageBuilder( $this->getContext() ) );

		return $builder->getText();
	}

	/**
	 * @since 0.1
	 */
	protected function canNotRead( $reader ) {
		return $this->msg( 'composerpackages-file-not-available', $reader->getFileName() );
	}

}
