<?php

namespace ExtensionManager;

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
	 * @param FileInfo $sourceFile
	 */
	public function __construct( FileInfo $sourceFile ) {
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

		if ( !$this->isValidJson( $fileContents, json_last_error() ) ) {
			throw new UnexpectedValueException( 'File contents is not JSON compatible' );
		}

		return $fileContents;
	}

	protected function assertFileExists( $file ) {
		return file_exists( $file );
	}

	protected function fetchFileContents( $file ) {
		return file_get_contents( $file );
	}

	private function isValidJson( $decode, $error ) {
		return $decode !== null && (array)$decode === $decode && $error === JSON_ERROR_NONE;
	}

}
