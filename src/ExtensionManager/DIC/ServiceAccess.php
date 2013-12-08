<?php

namespace ExtensionManager\DIC;

use ServiceRegistry\ServiceRegistry;

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
class ServiceAccess {

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
		return new ServiceBuilder( self::newServiceRegistry() );
	}

	private static function newServiceRegistry() {
		$dir = defined( 'MW_PHPUNIT_TEST' ) ? __DIR__ . '/../../../' : $GLOBALS['IP'];

		return new ServiceRegistry( new ServicesContainer( $dir, 'composer.lock' ) );
	}

}