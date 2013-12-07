<?php

namespace ComposerPackages\Test;

use ServiceRegistry\ServiceRegistry;

/**
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class ServicesContainerSetupIntegrationTest extends \PHPUnit_Framework_TestCase {

	protected function setUp() {
		if ( !defined( 'MEDIAWIKI' ) ) {
			$this->markTestSkipped( 'MediaWiki is not available' );
		}

		parent::setUp();
	}

	/**
	 * @since 0.1
	 */
	public function testAvailableServices() {
		$requestContext = $this->getMockBuilder( '\RequestContext' )
			->disableOriginalConstructor()
			->getMock();

		$instance = ServiceRegistry::getInstance( 'composerpackages' );
		$instance->registerObject( 'RequestContext', function() use( $requestContext ) { return $requestContext; } );

		foreach( $instance->getAllServices() as $service => $signature ) {
			$this->assertTrue( is_callable( $signature ) );
			$this->assertTrue( is_object( $instance->newObject( $service ) ) );
		}

		$this->assertArrayHasKey( 'FileReader', $instance->getAllServices() );
		$this->assertInstanceOf( 'ComposerPackages\JsonFileReader', $instance->newObject( 'FileReader' ) );
	}

}
