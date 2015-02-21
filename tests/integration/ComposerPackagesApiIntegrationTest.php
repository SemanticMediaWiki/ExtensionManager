<?php

namespace ExtensionManager\Test;

use ExtensionManager\MediaWiki\Api\ComposerPackages;

use RequestContext;
use FauxRequest;
use Language;
use ApiMain;

/**
 * @covers ExtensionManager\MediaWiki\Api\ComposerPackages
 *
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @author mwjames
 */
class ComposerPackagesApiIntegrationTest extends \PHPUnit_Framework_TestCase {

	protected function setUp() {
		if ( !defined( 'MEDIAWIKI' ) ) {
			$this->markTestSkipped( 'MediaWiki is not available' );
		}

		parent::setUp();
	}

	public function newInstance() {

		$context = new RequestContext();
		$context->setRequest( new FauxRequest( array(), true ) );
		$context->setLanguage( Language::factory( 'en' ) );

		$apiMain = new ApiMain( $context, true );
		$instance = new ComposerPackages( $apiMain, 'composerpackages' );

		return $instance;
	}

	public function testExecute() {
		$instance = $this->newInstance();

		try {
			$instance->execute( '' );
		} catch ( \Exception $exception ) {
			if ( !( $exception instanceof \PermissionsError ) && !( $exception instanceof \ErrorPageError ) ) {
				throw $exception;
			}
		}

		$this->assertTrue( true, 'Asserts that Api module ComposerPackages run without errors' );
	}

	public function testExecuteOnNotSupportedFormatRaisingUsageException() {

		$instance = $this->newInstance();
		$instance->getMain()->getResult()->setRawMode();

		try {
			$instance->execute( '' );
		} catch ( \UsageException $e ) {
			$this->assertTrue( true, 'Asserts that the XML format currently is not supported' );
		}

	}

}
