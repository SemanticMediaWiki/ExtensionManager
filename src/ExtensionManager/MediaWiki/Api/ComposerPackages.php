<?php

namespace ExtensionManager\MediaWiki\Api;

use ExtensionManager\JsonFileReader;
use ServiceRegistry\ServiceRegistry;

use ApiBase;

/**
 * Api module ...
 *
 * @ingroup ComposerPackages
 *
 * @licence GNU GPL v2+
 * @since 1.9
 *
 * @author mwjames
 */
class ComposerPackages extends ApiBase {

	/**
	 * @see ApiBase::execute
	 */
	public function execute() {

		/**
		 * @var JsonFileReader $reader
		 */
		$reader = ServiceRegistry::getInstance( 'composerpackages' )->newObject( 'FileReader' );

		if ( !$reader->canReadFile() ) {
			$this->dieUsageMsg( array( 'illegal-filename' ) );
		};

		$packages = $reader->decodeJsonFile();

		$this->getResult()->addValue( null, 'query', $this->runFormatter( $packages ) );
	}

	/**
	 * @since 0.1
	 */
	protected function runFormatter( $packages ) {

		if ( $this->getResult()->getIsRawMode() ) {
			$this->dieUsageMsg( array( 'Selected format is not supported' ) );
		};

		return $packages;
	}

	/**
	 * @codeCoverageIgnore
	 * @see ApiBase::getAllowedParams
	 *
	 * @return array
	 */
	public function getAllowedParams() {
		return array();
	}

	/**
	 * @codeCoverageIgnore
	 * @see ApiBase::getParamDescription
	 *
	 * @return array
	 */
	public function getParamDescription() {
		return array();
	}

	/**
	 * @codeCoverageIgnore
	 * @see ApiBase::getDescription
	 *
	 * @return array
	 */
	public function getDescription() {
		return array(
			'A module to query installed composer packages.'
		);
	}

	/**
	 * @codeCoverageIgnore
	 * @see ApiBase::getExamples
	 *
	 * @return array
	 */
	protected function getExamples() {
		return array(
			'api.php?action=composerpackages',
		);
	}

	/**
	 * @codeCoverageIgnore
	 * @see ApiBase::getVersion
	 *
	 * @return string
	 */
	public function getVersion() {
		return __CLASS__ . '-' . EXTENSION_MANAGER_VERSION;
	}

}
