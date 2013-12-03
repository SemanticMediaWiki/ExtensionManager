<?php

namespace ComposerPackages;

use ServiceRegistry\ServiceContainer;
use Html;

/**
 * @see ServiceRegistry::ServiceContainer
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
	 * @param string $directory
	 * @param string $file
	 */
	public function __construct( $directory, $file ) {
		$this->directory = $directory;
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

		$directory = $this->directory;
		$file = $this->file;

		return function( $builder ) use ( $directory, $file ) {

			$builder->registerObject( 'FileReader', function ( $builder ) use ( $directory, $file ) {
				return new ComposerFileReader( new PackagesFile( $directory, $file ) );
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
