<?php

namespace ExtensionManager;

use ExtensionManager\ComposerContentMapper;
use ExtensionManager\FileInfo;
use ExtensionManager\HtmlFormatter;
use ExtensionManager\JsonFileReader;
use ExtensionManager\UI\PackageTableBuilder;
use Html;
use i18n\MediaWiki\LanguageTypes;
use i18n\MediaWiki\MessageBuilderFactory;
use IContextSource;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class ServiceBuilder {

	private $path;
	private $file;

	public function __construct( $path, $file ) {
		$this->path = $path;
		$this->file =$file;
	}

	/**
	 * @param IContextSource $context
	 *
	 * @return PackageTableBuilder
	 */
	public function newPackageTableBuilder( IContextSource $context ) {
		$factory = new MessageBuilderFactory();

		$messageBuilder = $factory->newMessageBuilder(
			$context,
			LanguageTypes::INTERFACE_LANGUAGE
		);

		return new PackageTableBuilder(
			new ComposerContentMapper( $this->newFileReader() ),
			$messageBuilder,
			new HtmlFormatter( new Html() )
		);
	}

	private function newFileReader() {
		return new JsonFileReader( new FileInfo( $this->path, $this->file ) );
	}

	/**
	 * TODO: define clear responsibilities
	 *
	 * @return JsonFileReader
	 */
	public function newObjectThatReadsAndParsesSomeSpecificJson() {
		return $this->newFileReader();
	}

}