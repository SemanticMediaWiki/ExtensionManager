<?php

namespace ExtensionManager\Test;

use ExtensionManager\TextBuilder;
use ExtensionManager\ComposerContentMapper;

/**
 * @covers \ExtensionManager\TextBuilder
 *
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class TextBuilderTest extends \PHPUnit_Framework_TestCase {

	protected $mockContent = array(
		'packages' => array(
			array(
				"name"    => "foo",
				"version" => "1.0",
				"type"    => "library",
				"time"    => "2013-11-17 21:03:14",
				"require" => array(
					"bar" => "~0.1",
					"php" => ">=5.3.0"
				)
			)
		)
	);

	/**
	 * @since 0.1
	 */
	public function newMessageBuilderMock() {

		$messageBuilder = $this->getMockBuilder( '\ExtensionManager\MessageBuilder' )
			->disableOriginalConstructor()
			->setMethods( array( 'getText' ) )
			->getMock();

		$messageBuilder->expects( $this->any() )
			->method( 'getText' )
			->will( $this->returnValue( 'Foo' ) );

		return $messageBuilder;
	}

	/**
	 * @since 0.1
	 */
	public function newHtmlFormatterMock() {

		$messageBuilder = $this->getMockBuilder( '\ExtensionManager\HtmlFormatter' )
			->disableOriginalConstructor()
			->setMethods( array( 'createElement' ) )
			->getMock();

		$messageBuilder->expects( $this->any() )
			->method( 'createElement' )
			->will( $this->returnValue( 'Foo' ) );

		return $messageBuilder;
	}

	/**
	 * @since 0.1
	 */
	public function newFileReaderMock( $contents = array() ) {

		$fileReader = $this->getMockBuilder( '\ExtensionManager\JsonFileReader' )
			->disableOriginalConstructor()
			->setMethods( array( 'decodeJsonFile' ) )
			->getMock();

		$fileReader->expects( $this->any() )
			->method( 'decodeJsonFile' )
			->will( $this->returnValue( $contents ) );

		return $fileReader;
	}

	/**
	 * @since 0.1
	 */
	public function newInstance( $contents = array() ) {
		return new TextBuilder(
			new ComposerContentMapper( $this->newFileReaderMock( $contents ) ),
			$this->newMessageBuilderMock(),
			$this->newHtmlFormatterMock()
		);
	}

	/**
	 * @since 0.1
	 */
	public function testCanConstruct() {
		$this->assertInstanceOf( '\ExtensionManager\TextBuilder', $this->newInstance() );
	}

	/**
	 * @since 0.1
	 */
	public function testGetText() {
		$this->assertInternalType( 'string', $this->newInstance( $this->mockContent )->getText() );
	}

}
