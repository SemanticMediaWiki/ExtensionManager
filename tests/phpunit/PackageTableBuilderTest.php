<?php

namespace ExtensionManager\Test;

use ExtensionManager\UI\PackageTableBuilder;
use ExtensionManager\ComposerContentMapper;

/**
 * @covers ExtensionManager\UI\PackageTableBuilder
 *
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @author mwjames
 */
class PackageTableBuilderTest extends \PHPUnit_Framework_TestCase {

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

	public function newMessageBuilderMock() {

		$messageBuilder = $this->getMockBuilder( 'i18n\MessageBuilder' )
			->disableOriginalConstructor()
			->setMethods( array( 'msgText' ) )
			->getMock();

		$messageBuilder->expects( $this->any() )
			->method( 'msgText' )
			->will( $this->returnValue( 'Foo' ) );

		return $messageBuilder;
	}

	public function newHtmlFormatterMock() {

		$messageBuilder = $this->getMockBuilder( 'ExtensionManager\HtmlFormatter' )
			->disableOriginalConstructor()
			->setMethods( array( 'createElement' ) )
			->getMock();

		$messageBuilder->expects( $this->any() )
			->method( 'createElement' )
			->will( $this->returnValue( 'Foo' ) );

		return $messageBuilder;
	}

	public function newFileReaderMock( $contents = array() ) {

		$fileReader = $this->getMockBuilder( 'ExtensionManager\JsonFileReader' )
			->disableOriginalConstructor()
			->setMethods( array( 'decodeJsonFile' ) )
			->getMock();

		$fileReader->expects( $this->any() )
			->method( 'decodeJsonFile' )
			->will( $this->returnValue( $contents ) );

		return $fileReader;
	}

	public function newInstance( $contents = array() ) {
		return new PackageTableBuilder(
			new ComposerContentMapper( $this->newFileReaderMock( $contents ) ),
			$this->newMessageBuilderMock(),
			$this->newHtmlFormatterMock()
		);
	}

	public function testCanConstruct() {
		$this->assertInstanceOf( 'ExtensionManager\UI\PackageTableBuilder', $this->newInstance() );
	}

	public function testGetText() {
		$this->assertInternalType( 'string', $this->newInstance( $this->mockContent )->getText() );
	}

}
