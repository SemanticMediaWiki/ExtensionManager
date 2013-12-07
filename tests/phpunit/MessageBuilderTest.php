<?php

namespace ExtensionManager\Test;

use ExtensionManager\MessageBuilder;

/**
 * @covers \ExtensionManager\MessageBuilder
 *
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class MessageBuilderTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @since 0.1
	 */
	public function newContextSourceMock( $text ) {

		if ( !interface_exists( 'IContextSource' ) ) {
			$this->markTestSkipped( 'IContextSource is not available' );
		}

		$msg = new ExtensibleMock();
		$msg->text = function() use ( $text ) { return $text; };

		$contextSource = $this->getMockBuilder( '\IContextSource' )
			->disableOriginalConstructor()
			->getMock();

		$contextSource->expects( $this->any() )
			->method( 'msg' )
			->will( $this->returnValue( $msg ) );

		return $contextSource;
	}

	/**
	 * @since 0.1
	 */
	public function newInstance( $text = 'Foo' ) {
		return new MessageBuilder( $this->newContextSourceMock( $text ) );
	}

	/**
	 * @since 0.1
	 */
	public function testCanConstruct() {
		$this->assertInstanceOf( '\ExtensionManager\MessageBuilder', $this->newInstance() );
	}

	/**
	 * @since 0.1
	 */
	public function testGetText() {
		$this->assertEquals( 'Qyye' , $this->newInstance( 'Qyye' )->getText() );
	}

}

class ExtensibleMock {

	public function __call( $method, $args ) {
		if ( isset( $this->$method ) && is_callable( $this->$method ) ) {
			$func = $this->$method;
			return call_user_func_array( $func, $args );
		}
	}
}