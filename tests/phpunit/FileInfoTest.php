<?php

namespace ExtensionManager\Test;

use ExtensionManager\FileInfo;

/**
 * @covers ExtensionManager\FileInfo
 *
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class FileInfoTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @since 0.1
	 */
	public function newInstance( $dir, $file ) {
		return new FileInfo( $dir, $file );
	}

	/**
	 * @since 0.1
	 */
	public function testGetFileName() {
		$this->assertEquals( 'composer.lock', $this->newInstance( 'abc', 'composer.lock' )->getFileName() );
		$this->assertEquals( 'foo', $this->newInstance( 'abc', 'foo')->getFileName() );
	}

	/**
	 * @since 0.1
	 */
	public function testGetDirectory() {
		$this->assertInternalType( 'string', $this->newInstance( 'abc', 'composer.lock' )->getDirectory() );
		$this->assertInternalType( 'string', $this->newInstance( 'foo', 'bar' )->getDirectory() );
	}

	/**
	 * @since 0.1
	 */
	public function testGetFullPath() {
		$this->assertInternalType( 'string', $this->newInstance( 'foo', 'composer.lock' )->getFullPath() );
		$this->assertInternalType( 'string', $this->newInstance( 'foo', 'bar' )->getFullPath() );
	}

}
