<?php

namespace ComposerPackages;

use ServiceRegistry\ServiceContainer;
use Html;

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
	 * @return Closure
	 */
	public function loadAllDefinitions() {

		$path = $this->path;
		$file = $this->file;

		return function( $builder ) use ( $path, $file ) {

			$builder->registerObject( 'FileReader', function ( $builder ) use ( $path, $file ) {
				return new JsonFileReader( new FileLocator( $path, $file ) );
			} );

			$builder->registerObject( 'ContentMapper', function ( $builder ) {
				return new ComposerContentMapper( $builder->newObject( 'FileReader' ) );
			} );

			$builder->registerObject( 'MessageBuilder', function ( $builder ) {
				return new MessageBuilder( $builder->newObject( 'RequestContext' ) );
			} );

			$builder->registerObject( 'HtmlFormatter', function ( $builder ) {
				return new HtmlFormatter( new Html() );
			} );

			$builder->registerObject( 'TextBuilder', function ( $builder ) {
				return new TextBuilder(
					$builder->newObject( 'ContentMapper' ),
					$builder->newObject( 'MessageBuilder' ),
					$builder->newObject( 'HtmlFormatter' )
				);
			} );

		};

	}

}
