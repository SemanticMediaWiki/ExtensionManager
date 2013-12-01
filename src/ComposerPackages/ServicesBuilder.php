<?php

namespace ComposerPackages;

use Closure;
use InvalidArgumentException;
use RuntimeException;

/**
 * Provides a minimalistic service injection container
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class ServicesBuilder {

	/** @var ServicesBuilder */
	protected static $instance = null;

	/** @var array */
	protected $services = array();

	/**
	 * @since 0.1
	 *
	 * @param array $services
	 */
	public function __construct( array $services = array() ) {
		$this->services = $services;
	}

	/**
	 * @since 0.1
	 *
	 * @return ServicesBuilder
	 */
	public static function getInstance() {

		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @since 0.1
	 *
	 * @param string $key
	 * @param Closure $value
	 * @param string|null $scope
	 *
	 * @throws InvalidArgumentException
	 */
	public function registerObject( $key, $value, $scope = null ) {

		if ( !is_string( $key ) ) {
			throw new InvalidArgumentException( 'The key is expected to be a string' );
		}

		if ( !( $value instanceof Closure ) ) {
			throw new InvalidArgumentException( 'The value is expected to be a closure' );
		}

		$this->attach( $key, $scope !== null ? $this->addSingleton( $value ) : $value );
	}

	/**
	 * @since 0.1
	 *
	 * @param string $key
	 * @param array|null $arguments
	 *
	 * @return mixed
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 */
	public function newObject( $key, $arguments = null ) {

		if ( !is_string( $key ) ) {
			throw new InvalidArgumentException( 'The key is expected to be a string' );
		}

		if ( !$this->contains( $key ) ) {
			throw new RuntimeException( "Requested service {$key} is not available" );
		}

		$this->addArguments( $arguments );

		$objectSignature = $this->lookup( $key );

		return is_callable( $objectSignature ) ? $objectSignature( $this ) : $objectSignature;
	}

	/**
	 * @since 0.1
	 *
	 * @return array
	 */
	public function getAllServices() {
		return array_keys( $this->services );
	}

	/**
	 * @since 0.1
	 */
	protected function addSingleton( $value ) {
		return function ( $builder ) use ( $value ) {
			static $singleton;

			if ( $singleton === null ) {
				$singleton = $value( $builder );
			}

			return $singleton;
		};
	}

	/**
	 * @since 0.1
	 *
	 * @throws InvalidArgumentException
	 */
	protected function addArguments( $arguments ) {

		if ( is_array( $arguments ) ) {

			foreach ( $arguments as $key => $value ) {

				if ( !is_string( $key ) ) {
					throw new InvalidArgumentException( 'The argument key is expected to be a string' );
				}

				$this->attach( $key, $value );
			}
		}

	}

	/**
	 * @since 0.1
	 */
	protected function contains( $key ) {
		return isset( $this->services[$key] ) || array_key_exists( $key, $this->services );
	}

	/**
	 * @since 0.1
	 */
	protected function attach( $key, $value = null ) {
		$this->services[$key] = $value;
	}

	/**
	 * @since 0.1
	 */
	protected function lookup( $key ) {
		return $this->services[$key];
	}

}
