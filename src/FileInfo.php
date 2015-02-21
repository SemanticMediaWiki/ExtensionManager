<?php

namespace ExtensionManager;

use InvalidArgumentException;

/**
 * Represents the source file and by convention is using composer.lock
 * as default file
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class FileInfo {

	/**
	 * @since 0.1
	 *
	 * @param string $directory
	 * @param string $fileName
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( $directory, $fileName ) {
		if ( !is_string( $directory ) ) {
			throw new InvalidArgumentException( '$directory needs to be a string' );
		}

		if ( !is_string( $fileName ) ) {
			throw new InvalidArgumentException( '$fileName needs to be a string' );
		}

		$this->directory = $directory;
		$this->fileName = $fileName;
	}

	/**
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getFileName() {
		return $this->fileName;
	}

	/**
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getDirectory() {
		return $this->directory;
	}

	/**
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getFullPath() {
		return $this->getDirectory() . DIRECTORY_SEPARATOR . $this->getFileName();
	}

}
