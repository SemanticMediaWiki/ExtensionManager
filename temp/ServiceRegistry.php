<?php

namespace ServiceRegistry;

use Closure;

use InvalidArgumentException;
use OutOfBoundsException;
use RuntimeException;

/**
 * Provides a minimalistic service registry
 *
 * @group ServiceRegistry
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class ServiceRegistry implements RegistryInterface {

	/**
	 * @var ServiceRegistry
	 */
	protected static $instance = array();

	/**
	 * @var string
	 */
	protected $instanceId = null;

	/**
	 * @var array
	 */
	protected $container = array(
		'_serv_' => array(),
		'_arg_'  => array()
	);

	/**
	 * Iteration counter tracking the depth of a dependency graph
	 *
	 * @var integer
	 */
	protected $recursionLevel = 0;

	/**
	 * Specifies a max depth (or threshold) for a dependency graph
	 *
	 * @var integer
	 */
	protected $recursionDepth = 10;

	/**
	 * @since 0.1
	 *
	 * @param ServiceContainer $container
	 * @param string $instanceId
	 */
	public function __construct( ServiceContainer $container = null, $instanceId = null ) {

		if ( $container !== null ) {
			$this->registerContainer( $container );
		}

		$this->instanceId = $instanceId;

	}

	/**
	 * @since 0.1
	 *
	 * @param string $id id to separate access to an instance
	 *
	 * @return ServiceRegistry
	 */
	public static function getInstance( $id = 'shared' ) {

		if ( !isset( self::$instance[ $id ] ) ) {
			self::$instance[ $id ] = new self( null, $id );
		}

		return self::$instance[ $id ];
	}

	/**
	 * @since 0.1
	 *
	 * @param ServiceContainer|null $container
	 *
	 * @throws RuntimeException
	 */
	public function registerContainer( ServiceContainer $container ) {
		$definitions = $this->assertIsClosureOrSetOffException( $container->loadAllDefinitions() );
		$definitions( $this );
	}

	/**
	 * @since 0.1
	 *
	 * @param string $objectName
	 * @param Closure $objectSignature
	 * @param string|null $objectScope
	 *
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 */
	public function registerObject( $objectName, $objectSignature, $objectScope = null ) {

		$objectName = $this->assertIsStringOrSetOffException( $objectName );
		$objectSignature = $this->assertIsClosureOrSetOffException( $objectSignature );

		$objectSignature = $objectScope !== null ? $this->addSingleton( $objectSignature ) : $objectSignature;

		$this->attach( '_serv_', $objectName, $objectSignature );
	}

	/**
	 * @since 0.1
	 *
	 * @param string $objectName
	 * @param array|null $arguments
	 *
	 * @return mixed
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 * @throws OutOfBoundsException
	 */
	public function newObject( $objectName, $arguments = null ) {

		$objectName = $this->assertIsStringOrSetOffException( $objectName );

		if ( $this->recursionLevel++ > $this->recursionDepth ) {
			throw new OutOfBoundsException( "Possible circular reference for '{$objectName}' detected" );
		}

		$objectSignature = $this->findSignatureOrSetOffException( $objectName );

		if ( is_array( $arguments ) ) {
			$this->addArguments( $arguments );
		}

		$instance = is_callable( $objectSignature ) ? $objectSignature( $this ) : $objectSignature;
		$this->recursionLevel--;

		return $instance;
	}

	/**
	 * @since 0.1
	 *
	 * @return boolean
	 * @throws InvalidArgumentException
	 */
	public function hasObject( $objectName ) {
		$objectName = $this->assertIsStringOrSetOffException( $objectName );
		return $this->contains( '_serv_', $objectName ) || $this->contains( '_arg_', $objectName );
	}

	/**
	 * @since 0.1
	 *
	 * @return array
	 */
	public function getAllServices() {
		return $this->container['_serv_'];
	}

	/**
	 * @since 0.1
	 */
	public static function reset() {
		self::$instance = array();
	}

	/**
	 * @since 0.1
	 *
	 * @throws RuntimeException
	 */
	protected function findSignatureOrSetOffException( $objectName ) {

		if ( $this->contains( '_serv_', $objectName ) ) {
			return $this->lookup( '_serv_', $objectName );
		}

		if ( $this->contains( '_arg_', $objectName ) ) {
			return $this->lookup( '_arg_', $objectName );
		}

		throw new RuntimeException( "Requested '{$objectName}' service is not available for the {$this->instanceId} instance" );
	}

	/**
	 * @since 0.1
	 *
	 * @return Closure
	 */
	protected function addSingleton( $value ) {
		return function ( $registry ) use ( $value ) {
			static $singleton;

			if ( $singleton === null ) {
				$singleton = $value( $registry );
			}

			return $singleton;
		};
	}

	/**
	 * @since 0.1
	 *
	 * @throws InvalidArgumentException
	 */
	protected function addArguments( array $arguments ) {

		foreach ( $arguments as $key => $value ) {

			$key = $this->assertIsStringOrSetOffException( $key );

			$this->attach( '_arg_', $key, function() use( $value ) {
				return $value;
			} );
		}

	}

	/**
	 * @since 0.1
	 *
	 * @return string
	 * @throws InvalidArgumentException
	 */
	protected function assertIsStringOrSetOffException( $key ) {

		if ( !is_string( $key ) ) {
			throw new InvalidArgumentException( 'Key ought to be a string' );
		}

		return strtolower( $key );
	}

	/**
	 * @since 0.1
	 *
	 * @return Closure
	 * @throws RuntimeException
	 */
	protected function assertIsClosureOrSetOffException( $object ) {

		if ( !( $object instanceof Closure ) ) {
			throw new RuntimeException( 'Object ought to be a Closure' );
		}

		return $object;
	}

	/**
	 * @since 0.1
	 */
	protected function contains( $group, $key ) {
		return isset( $this->container[ $group ][ $key ] ) || array_key_exists( $key, $this->container[ $group ] );
	}

	/**
	 * @since 0.1
	 */
	protected function attach( $group, $key, $value = null ) {
		$this->container[ $group ][ $key ] = $value;
	}

	/**
	 * @since 0.1
	 */
	protected function lookup( $group, $key ) {
		return $this->container[ $group ][ $key ];
	}

}
