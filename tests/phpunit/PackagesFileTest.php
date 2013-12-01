<?php

namespace ComposerPackages\Test;

use ComposerPackages\PackagesFile;

/**
 * @covers \ComposerPackages\PackagesFile
 *
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class PackagesFileTest extends \PHPUnit_Framework_TestCase {

	/** @var boolean */
	private $requiredIPSetting = false;

	/**
	 * @return 0.1
	 */
	protected function setUp() {

		if ( !isset( $GLOBALS['IP'] ) ) {
			$GLOBALS['IP'] = 'Foo';
			$this->requiredIPSetting = true;
		}

		parent::setUp();

	}

	/**
	 * @return 0.1
	 */
	protected function tearDown() {
		parent::tearDown();

		if ( $this->requiredIPSetting ) {
			unset( $GLOBALS['IP'] );
		}
	}

	/**
	 * @since 0.1
	 */
	public function newInstance( $dir = null, $file = null ) {
		return new PackagesFile( $dir, $file );
	}

	/**
	 * @since 0.1
	 */
	public function testCanConstruct() {
		$this->assertInstanceOf( '\ComposerPackages\PackagesFile', $this->newInstance() );
	}

	/**
	 * @since 0.1
	 */
	public function testGetFileName() {
		$this->assertEquals( 'composer.lock', $this->newInstance( null, null )->getFileName() );
		$this->assertEquals( 'foo', $this->newInstance( null, 'foo')->getFileName() );
	}

	/**
	 * @since 0.1
	 */
	public function testGetDirectory() {
		$this->assertInternalType( 'string', $this->newInstance( null, null )->getDirectory() );
		$this->assertInternalType( 'string', $this->newInstance( 'foo', null )->getDirectory() );
	}

	/**
	 * @since 0.1
	 */
	public function testGetFullPath() {
		$this->assertInternalType( 'string', $this->newInstance( null, null )->getFullPath() );
		$this->assertInternalType( 'string', $this->newInstance( 'foo', null )->getFullPath() );
		$this->assertInternalType( 'string', $this->newInstance( null, 'bar' )->getFullPath() );
		$this->assertInternalType( 'string', $this->newInstance( 'foo', 'bar' )->getFullPath() );
	}

}
