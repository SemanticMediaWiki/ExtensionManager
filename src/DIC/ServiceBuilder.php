<?php

namespace ExtensionManager\DIC;

use ExtensionManager\JsonFileReader;
use ExtensionManager\UI\PackageTableBuilder;
use IContextSource;
use ServiceRegistry\RegistryInterface;

/**
 * This class exposes methods to retrieve each type of generally accessible object
 * from the dependency manager. This is the only class that should retrieve objects
 * from the dependency manager.
 *
 * It is responsible for having the dependency manager construct the appropriate
 * object, or for retrieving it from an in-object cache where applicable.
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class ServiceBuilder {

	private $serviceRegistry;

	public function __construct( RegistryInterface $serviceRegistry ) {
		$this->serviceRegistry = $serviceRegistry;
	}

	/**
	 * @param IContextSource $context
	 *
	 * @return PackageTableBuilder
	 */
	public function newPackageTableBuilder( IContextSource $context ) {
		return $this->serviceRegistry->newObject(
			'packageTableHtmlBuilder',
			array(
				'RequestContext' => $context
			)
		);
	}

	/**
	 * TODO: define clear responsibilities
	 *
	 * @return JsonFileReader
	 */
	public function newObjectThatReadsAndParsesSomeSpecificJson() {
		return $this->serviceRegistry->newObject( 'FileReader' );
	}

}