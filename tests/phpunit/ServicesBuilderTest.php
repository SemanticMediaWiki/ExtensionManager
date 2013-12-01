<?php

namespace ComposerPackages\Test;

use ComposerPackages\ServicesBuilder;

/**
 * @covers \ComposerPackages\ServicesBuilder
 *
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class ServicesBuilderTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @since 0.1
	 */
	public function newInstance() {
		return new ServicesBuilder();
	}

	/**
	 * @since 0.1
	 */
	public function testCanConstruct() {
		$this->assertInstanceOf( '\ComposerPackages\ServicesBuilder', $this->newInstance() );
		$this->assertInstanceOf( '\ComposerPackages\ServicesBuilder', ServicesBuilder::getInstance() );
	}

	/**
	 * @since 0.1
	 */
	public function testRegisterObjectAsPrototype() {

		$object = function( $builder ) {
			return new \stdClass;
		};

		$instance = $this->newInstance();
		$instance->registerObject( 'Foo', $object );

		$this->assertInstanceOf( '\stdClass', $instance->newObject( 'Foo' ) );
		$this->assertFalse( $instance->newObject( 'Foo' ) === $instance->newObject( 'Foo' ) );

	}

	/**
	 * @since 0.1
	 */
	public function testRegisterInvalidObjectSetOffInvalidArgumentException() {

		$this->setExpectedException( 'InvalidArgumentException' );

		$object = function( $builder ) {
			return new \stdClass;
		};

		$instance = $this->newInstance();
		$instance->registerObject( 'Foo', $object );

		$instance->newObject( array( 'Foo' ) );

	}

	/**
	 * @since 0.1
	 */
	public function testRegisterInvalidKeySetOffInvalidArgumentException() {

		$this->setExpectedException( 'InvalidArgumentException' );

		$object = function( $builder ) {
			return new \stdClass;
		};

		$this->newInstance()->registerObject( $object, null );

	}

	/**
	 * @since 0.1
	 */
	public function testRegisterInvalidObjectSignatureSetOffInvalidArgumentException() {

		$this->setExpectedException( 'InvalidArgumentException' );

		$this->newInstance()->registerObject( 'Foo', null );

	}

	/**
	 * @since 0.1
	 */
	public function testRegisterObjectAsSingleton() {

		$object = function( $builder ) {
			return new \stdClass;
		};

		$instance = $this->newInstance();
		$instance->registerObject( 'Foo', $object, 'singleton' );

		$this->assertInstanceOf( '\stdClass', $instance->newObject( 'Foo' ) );
		$this->assertTrue( $instance->newObject( 'Foo' ) === $instance->newObject( 'Foo' ) );

	}

	/**
	 * @since 0.1
	 */
	public function testRegisterObjectWithArgument() {

		$object = function( $builder ) {

			$instance = new \stdClass;
			$instance->foo = $builder->newObject( 'Bar' );

			return $instance;
		};

		$instance = $this->newInstance();
		$instance->registerObject( 'Foo', $object );

		$newObject = $instance->newObject( 'Foo', array(
			'Bar' => 'FooBar'
		) );

		$this->assertInstanceOf( '\stdClass', $newObject );
		$this->assertEquals( 'FooBar', $newObject->foo );

	}

	/**
	 * @since 0.1
	 */
	public function testRegisterObjectWithInvalidArgumentSetOffInvalidArgumentException() {

		$this->setExpectedException( 'InvalidArgumentException' );

		$object = function( $builder ) {

			$instance = new \stdClass;
			$instance->foo = $builder->newObject( 'Bar' );

			return $instance;
		};

		$instance = $this->newInstance();
		$instance->registerObject( 'Foo', $object );

		$instance->newObject( 'Foo', array(
			new \stdClass
		) );

	}

	/**
	 * @since 0.1
	 */
	public function testRegisterObjectWithMissingObjectSetOffRuntimeException() {

		$this->setExpectedException( 'RuntimeException' );

		$object = function( $builder ) {

			$instance = new \stdClass;
			$instance->foo = $builder->newObject( 'Bar' );

			return $instance;
		};

		$instance = $this->newInstance();
		$instance->registerObject( 'Foo', $object );

		$instance->newObject( 'Foo' );

	}

	/**
	 * @since 0.1
	 */
	public function testGetAllServices() {

		$object = function( $builder ) {
			return new \stdClass;
		};

		$instance = $this->newInstance();
		$instance->registerObject( 'FooMan', $object );
		$instance->registerObject( 'FanMu', $object );

		$this->assertEquals(
			array( 'FooMan', 'FanMu' ),
			$instance->getAllServices()
		);

	}

}
