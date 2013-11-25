<?php

namespace ComposerPackages\Test;

use ComposerPackages\Specials\ListComposerPackages;

use SpecialPageFactory;
use RequestContext;
use FauxRequest;
use Language;

/**
 * @covers \ComposerPackages\Specials\ListComposerPackages
 *
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class ListComposerPackagesSpecialPageIntegrationTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @since 0.1
	 */
	public function newInstance() {

		$special = SpecialPageFactory::getPage( 'ListComposerPackages' );

		$context = RequestContext::newExtraneousContext( $special->getTitle() );
		$context->setRequest( new FauxRequest( array(), true ) );
		$context->setLanguage( Language::factory( 'en' ) );

		$special->setContext( clone $context );

		return $special;
	}

	/**
	 * @since 0.1
	 */
	public function testExecute() {

		try {
			$this->newInstance()->execute( '' );
		} catch ( \Exception $exception ) {
			if ( !( $exception instanceof \PermissionsError ) && !( $exception instanceof \ErrorPageError ) ) {
				throw $exception;
			}
		}

		$this->assertTrue( true, 'Asserts that ListComposerPackages can run without errors' );
	}

}
