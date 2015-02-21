<?php

namespace ExtensionManager;

/**
 * Static access to the dependency injection container.
 *
 * Usage of this class is only allowed at entry points, such as
 * hook handlers, API modules and special pages.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class ServiceAccess {

	private static $instance = null;

	/**
	 * @return ServiceBuilder
	 */
	public static function getInstance() {
		if ( self::$instance === null ) {
			self::$instance = self::newServiceBuilder();
		}

		return self::$instance;
	}

	private static function newServiceBuilder() {
		$dir = defined( 'MW_PHPUNIT_TEST' ) ? __DIR__ . '/../' : $GLOBALS['IP'];

		return new ServiceBuilder( $dir, 'composer.lock' );
	}

}