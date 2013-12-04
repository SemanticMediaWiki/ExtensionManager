<?php

namespace ComposerPackages;

use InvalidArgumentException;
use UnexpectedValueException;

/**
 * Class to decode json file
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class JsonFileReader {

	/**
	 * @since 0.1
	 *
	 * @param FileLocator $sourceFile
	 */
	public function __construct( FileLocator $sourceFile ) {
		$this->sourceFile = $sourceFile;
	}

	/**
	 * @since 0.1
	 *
	 * @return boolean
	 */
	public function canReadFile() {
		return $this->assertFileExists( $this->sourceFile->getFullPath() );
	}

	/**
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getFileName() {
		return $this->sourceFile->getFileName();
	}

	/**
	 * @since 0.1
	 *
	 * @return array
	 * @throws InvalidArgumentException
	 * @throws UnexpectedValueException
	 */
	public function decodeJsonFile() {

		$file = $this->sourceFile->getFullPath();

		if ( !$this->assertFileExists( $file ) ) {
			throw new InvalidArgumentException( 'File does not exist' );
		}

		$fileContents = json_decode( $this->fetchFileContents( $file ), true );

		if ( !$this->assertValidJson( $fileContents, json_last_error() ) ) {
			throw new UnexpectedValueException( 'File contents is not JSON compatible' );
		}

		return $fileContents;
	}

	/**
	 * @since 0.1
	 */
	protected function assertFileExists( $file ) {
		return file_exists( $file );
	}

	/**
	 * @since 0.1
	 */
	protected function fetchFileContents( $file ) {
		return file_get_contents( $file );
	}

	/**
	 * @since 0.1
	 */
	protected function assertValidJson( $decode, $error ) {
		return $decode !== null && (array)$decode === $decode && $error === JSON_ERROR_NONE;
	}

}
