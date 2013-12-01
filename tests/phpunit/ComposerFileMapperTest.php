<?php

namespace ComposerPackages\Test;

use ComposerPackages\ComposerFileMapper;

/**
 * @covers \ComposerPackages\ComposerFileMapper
 *
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class ComposerFileMapperTest extends \PHPUnit_Framework_TestCase {

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
	public function newPackagesFileReaderMock( $contents = array() ) {

		$fileReader = $this->getMockBuilder( '\ComposerPackages\PackagesFileReader' )
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
		return new ComposerFileMapper( $this->newPackagesFileReaderMock( $contents ) );
	}

	/**
	 * @since 0.1
	 */
	public function testCanConstruct() {
		$this->assertInstanceOf( '\ComposerPackages\ComposerFileMapper', $this->newInstance() );
	}

	/**
	 * @since 0.1
	 */
	public function testGetElement() {

		$instance = $this->newInstance( $this->mockContent );

		foreach ( $instance->getPackages() as $package ) {
			$this->assertInternalType( 'string', $instance->getElement( 'name', $package ) );
		}

	}

	/**
	 * @since 0.1
	 */
	public function testFindPackage() {
		$this->assertInternalType(
			'array',
			$this->newInstance( $this->mockContent )->findPackage( 'foo' )
		);
	}

}
