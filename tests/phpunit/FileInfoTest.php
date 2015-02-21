<?php

namespace ExtensionManager\Test;

use ExtensionManager\FileInfo;

/**
 * @covers ExtensionManager\FileInfo
 *
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @author mwjames
 */
class FileInfoTest extends \PHPUnit_Framework_TestCase {

	public function newInstance( $dir, $file ) {
		return new FileInfo( $dir, $file );
	}

	public function testGetFileName() {
		$this->assertEquals( 'composer.lock', $this->newInstance( 'abc', 'composer.lock' )->getFileName() );
		$this->assertEquals( 'foo', $this->newInstance( 'abc', 'foo')->getFileName() );
	}

	public function testGetDirectory() {
		$this->assertInternalType( 'string', $this->newInstance( 'abc', 'composer.lock' )->getDirectory() );
		$this->assertInternalType( 'string', $this->newInstance( 'foo', 'bar' )->getDirectory() );
	}

	public function testGetFullPath() {
		$this->assertInternalType( 'string', $this->newInstance( 'foo', 'composer.lock' )->getFullPath() );
		$this->assertInternalType( 'string', $this->newInstance( 'foo', 'bar' )->getFullPath() );
	}

}
