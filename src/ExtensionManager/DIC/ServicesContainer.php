<?php

namespace ExtensionManager\DIC;

use ExtensionManager\ComposerContentMapper;
use ExtensionManager\FileInfo;
use ExtensionManager\HtmlFormatter;
use ExtensionManager\JsonFileReader;
use ExtensionManager\UI\PackageTableBuilder;
use i18n\MediaWiki\LanguageTypes;
use i18n\MediaWiki\MessageBuilderFactory;
use ServiceRegistry\ServiceContainer;
use Html;
use ServiceRegistry\ServiceRegistry;

/**
 * Implements ServiceContainer to specify available services.
 *
 * This class is internal to the dependency injection mechanism
 * and should not be used directly from the application. All
 * access should happen through the ServiceAccess.
 *
 * No caching should be done on this level.
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class ServicesContainer implements ServiceContainer {

	/**
	 * @since 0.1
	 *
	 * @param string $path
	 * @param string $file
	 */
	public function __construct( $path, $file ) {
		$this->path = $path;
		$this->file = $file;
	}

	/**
	 * @see ServiceContainer::loadAllDefinitions
	 *
	 * @since 0.1
	 *
	 * @return callable
	 */
	public function loadAllDefinitions() {

		$path = $this->path;
		$file = $this->file;

		return function( ServiceRegistry $builder ) use ( $path, $file ) {

			$builder->registerObject( 'FileReader', function ( ServiceRegistry $builder ) use ( $path, $file ) {
				return new JsonFileReader( new FileInfo( $path, $file ) );
			} );

			$builder->registerObject( 'ContentMapper', function ( ServiceRegistry $builder ) {
				return new ComposerContentMapper( $builder->newObject( 'FileReader' ) );
			} );

			$builder->registerObject( 'MessageBuilder', function ( ServiceRegistry $builder ) {
				$factory = new MessageBuilderFactory();

				return $factory->newMessageBuilder(
					$builder->newObject( 'RequestContext' ),
					LanguageTypes::INTERFACE_LANGUAGE
				);
			} );

			$builder->registerObject( 'HtmlFormatter', function ( ServiceRegistry $builder ) {
				return new HtmlFormatter( new Html() );
			} );

			$builder->registerObject( 'packageTableHtmlBuilder', function ( ServiceRegistry $builder ) {
				return new PackageTableBuilder(
					$builder->newObject( 'ContentMapper' ),
					$builder->newObject( 'MessageBuilder' ),
					$builder->newObject( 'HtmlFormatter' )
				);
			} );

		};

	}

}
