<?php

namespace ExtensionManager;

/**
 * Represents the source file and by convention is using composer.lock
 * as default file
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class FileLocator {

	/**
	 * @since 0.1
	 *
	 * @param string|null $directory
	 * @param string|null $fileName
	 */
	public function __construct( $directory = null, $fileName = null ) {
		$this->directory = $directory;
		$this->fileName = $fileName;
	}

	/**
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getFileName() {
		return $this->fileName === null ? 'composer.lock' : $this->fileName;
	}

	/**
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getDirectory() {
		return $this->directory === null ? $GLOBALS['IP'] : $this->directory;
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
