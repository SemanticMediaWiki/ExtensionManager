<?php

namespace ComposerPackages\Api;

use ComposerPackages\PackagesFile;
use ComposerPackages\PackagesFileReader;

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

		$reader = new PackagesFileReader( new PackagesFile() );

		if ( !$reader->canReadFile() ) {
			$this->dieUsageMsg( array( 'illegal-filename' ) );
		};

		if ( $this->getResult()->getIsRawMode() ) {
			$this->dieUsageMsg( array( 'Format is not supported' ) );
		};

		$packages = $reader->decodeJsonFile();

		$this->getResult()->addValue( null, 'query', $this->runFormatter( $packages ) );
	}

	/**
	 * @since 0.1
	 */
	protected function runFormatter( &$packages ) {
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
			'API module to query installed composer packages.'
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
		return __CLASS__ . '-' . SMW_VERSION;
	}

}
