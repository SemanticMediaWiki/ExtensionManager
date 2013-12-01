<?php

namespace ComposerPackages\Test;

use ComposerPackages\Api\ComposerPackages;

/**
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class ExtensionFunctionsSetupIntegrationTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @since 0.1
	 */
	public function testCanConstruct() {

		$instance = $GLOBALS['wgExtensionFunctions']['composerpackages'];

		$this->assertTrue( is_callable( $instance ) );
		$this->assertTrue( call_user_func( $instance ) );

	}

}
