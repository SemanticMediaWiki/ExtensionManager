<?php

namespace ExtensionManager\Test;

use ExtensionManager\HtmlFormatter;

/**
 * @covers ExtensionManager\HtmlFormatter
 *
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @author mwjames
 */
class HtmlFormatterTest extends \PHPUnit_Framework_TestCase {

	public function newHtmlMock( $text ) {

		if ( !class_exists( 'Html' ) ) {
			$this->markTestSkipped( 'Html class is not available' );
		}

		$html = $this->getMockBuilder( '\Html' )
			->disableOriginalConstructor()
			->getMock();

		$html->expects( $this->any() )
			->method( 'rawElement' )
			->will( $this->returnValue( $text ) );

		return $html;
	}

	public function newInstance( $text = 'Foo' ) {
		return new HtmlFormatter( $this->newHtmlMock( $text ) );
	}

	public function testCanConstruct() {
		$this->assertInstanceOf( '\ExtensionManager\HtmlFormatter', $this->newInstance() );
	}

	public function testCreateElement() {
		$this->assertInternalType( 'string', $this->newInstance()->createElement( 'Foo', 'Faa' ) );
	}

}
