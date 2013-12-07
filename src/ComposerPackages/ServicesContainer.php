<?php

namespace ComposerPackages;

use ServiceRegistry\ServiceContainer;
use Html;
use ServiceRegistry\ServiceRegistry;

/**
 * Implements ServiceContainer to specify available services
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
				return new JsonFileReader( new FileLocator( $path, $file ) );
			} );

			$builder->registerObject( 'ContentMapper', function ( ServiceRegistry $builder ) {
				return new ComposerContentMapper( $builder->newObject( 'FileReader' ) );
			} );

			$builder->registerObject( 'MessageBuilder', function ( ServiceRegistry $builder ) {
				return new MessageBuilder( $builder->newObject( 'RequestContext' ) );
			} );

			$builder->registerObject( 'HtmlFormatter', function ( ServiceRegistry $builder ) {
				return new HtmlFormatter( new Html() );
			} );

			$builder->registerObject( 'TextBuilder', function ( ServiceRegistry $builder ) {
				return new TextBuilder(
					$builder->newObject( 'ContentMapper' ),
					$builder->newObject( 'MessageBuilder' ),
					$builder->newObject( 'HtmlFormatter' )
				);
			} );

		};

	}

}
