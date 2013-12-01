<?php

/**
 * Initialization
 *
 * @author mwjames
 */

if ( defined( 'COMPOSERPACKAGES_VERSION' ) ) {
	return 1;
}

define( 'COMPOSERPACKAGES_VERSION', '0.1' );

if ( defined( 'MEDIAWIKI' ) ) {

	$GLOBALS['wgExtensionCredits']['other'][] = array(
		'path'            => __FILE__,
		'name'            => 'ComposerPackages',
		'version'         => COMPOSERPACKAGES_VERSION,
		'author'          => array( 'mwjames' ),
		'url'             => 'https://github.com/mwjames/composer-packages',
		'descriptionmsg'  => 'composerpackages-desc',
	);

	// Message class
	$GLOBALS['wgExtensionMessagesFiles']['ComposerPackages']      = __DIR__ . '/' . 'ComposerPackages.i18n.php';
	$GLOBALS['wgExtensionMessagesFiles']['ComposerPackagesAlias'] = __DIR__ . '/' . 'ComposerPackages.alias.php';

	// Special page
	$GLOBALS['wgSpecialPages']['ListComposerPackages'] = 'ComposerPackages\Specials\ListComposerPackages';

	// Api
	$GLOBALS['wgAPIModules']['composerpackages'] = 'ComposerPackages\Api\ComposerPackages';

	// Extension services registration
	$GLOBALS['wgExtensionFunctions']['composerpackages'] = function() {

		$directory = $GLOBALS['IP'];
		$services  = \ComposerPackages\ServicesBuilder::getInstance();

		$services->registerObject( 'FileReader', function ( $builder ) use ( $directory ) {
			return new \ComposerPackages\ComposerFileReader( new \ComposerPackages\PackagesFile( $directory, 'composer.lock' ) );
		} );

		$services->registerObject( 'ContentMapper', function ( $builder ) {
			return new \ComposerPackages\ComposerContentMapper( $builder->newObject( 'FileReader' ) );
		} );

		$services->registerObject( 'MessageBuilder', function ( $builder ) {
			return new \ComposerPackages\MessageBuilder( $builder->newObject( 'RequestContext' ) );
		} );

		$services->registerObject( 'HtmlFormatter', function ( $builder ) {
			return new \ComposerPackages\HtmlFormatter( new \Html() );
		} );

		$services->registerObject( 'TextBuilder', function ( $builder ) {
			return new \ComposerPackages\TextBuilder(
				$builder->newObject( 'ContentMapper' ),
				$builder->newObject( 'MessageBuilder' ),
				$builder->newObject( 'HtmlFormatter' )
			);
		} );

		return true;
	};
}