<?php

namespace ExtensionManager\Test;

use ExtensionManager\JsonFileReader;
use ExtensionManager\FileInfo;

/**
 * @covers ExtensionManager\JsonFileReader
 *
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @author mwjames
 */
class JsonFileReaderTest extends \PHPUnit_Framework_TestCase {

	protected $mockContent = '{
		"packages": [
			{
				"name": "foo",
				"version": "1.0",
				"require": {
					"bar": "~0.1",
					"php": ">=5.3.0"
				},
				"type": "library",
				"time": "2013-11-17 21:03:14"
			}
		]
	}';

	public function newInstance( $path, $file ) {
		return new JsonFileReader( new FileInfo( $path, $file ) );
	}

	/**
	 * @return JsonFileReader
	 */
	public function newFileReaderMock( $exists = true, $contents = '' ) {
		$fileReader = $this->getMockBuilder( '\ExtensionManager\JsonFileReader' )
			->setConstructorArgs( array( new FileInfo( 'Foo', 'composer.json' ) ) )
			->setMethods( array( 'assertFileExists', 'fetchFileContents' ) )
			->getMock();

		$fileReader->expects( $this->any() )
			->method( 'assertFileExists' )
			->will( $this->returnValue( $exists ) );

		$fileReader->expects( $this->any() )
			->method( 'fetchFileContents' )
			->will( $this->returnValue( $contents ) );

		return $fileReader;
	}

	public function testCanReadFile() {
		$this->assertTrue( $this->newFileReaderMock( true )->canReadFile() );
		$this->assertFalse( $this->newFileReaderMock( false )->canReadFile() );
	}

	public function testDecodeJsonFile() {
		$this->assertInternalType(
			'array',
			$this->newFileReaderMock( true, $this->mockContent )->decodeJsonFile(),
			'Asserts that decodeJsonFile() return an array'
		);
	}

	public function testDecodeJsonFileInvalidFormatException() {

		$this->setExpectedException( 'UnexpectedValueException' );

		$this->assertInternalType(
			'array',
			$this->newFileReaderMock( true )->decodeJsonFile()
		);

	}

	public function testDecodeJsonFileInvalidFileException() {

		$this->setExpectedException( 'InvalidArgumentException' );

		$this->assertInternalType(
			'array',
			$this->newFileReaderMock( false )->decodeJsonFile()
		);

	}

}
