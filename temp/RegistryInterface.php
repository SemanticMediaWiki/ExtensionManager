<?php

namespace ServiceRegistry;

/**
 * Interface specifying the service registry
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
interface RegistryInterface {

	/**
	 * Retrieves service container
	 *
	 * @since 0.1
	 *
	 * @param ServiceContainer $container
	 */
	public function registerContainer( ServiceContainer $container );

	/**
	 * Register a dependency object
	 *
	 * @since 0.1
	 *
	 * @param $objectName
	 * @param $objectSignature
	 * @param $objectScope
	 */
	public function registerObject( $objectName, $objectSignature, $objectScope = null );

	/**
	 * Builds an object/service instance from an registered object graph
	 *
	 * @since 0.1
	 *
	 * @param $objectName
	 * @param $arguments
	 */
	public function newObject( $objectName, $arguments = null );

}
