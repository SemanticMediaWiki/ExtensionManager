<?php

/**
 * Initialization
 *
 * @author mwjames
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

define( 'COMPOSERPACKAGES_VERSION', '0.1' );

$GLOBALS['wgExtensionCredits']['other'][] = array(
	'path'            => __FILE__,
	'name'            => 'ComposerPackages',
	'version'         => COMPOSERPACKAGES_VERSION,
	'author'          => array( 'mwjames' ),
	'url'             => 'https://github.com/mwjames/composer-packages',
	'descriptionmsg'  => 'composerpackages-desc',
);

$dir = __DIR__ . '/';

// Message class
$GLOBALS['wgExtensionMessagesFiles']['ComposerPackages']      = $dir . 'ComposerPackages.i18n.php';
$GLOBALS['wgExtensionMessagesFiles']['ComposerPackagesAlias'] = $dir . 'ComposerPackages.alias.php';

// Special page
$GLOBALS['wgSpecialPages']['ListComposerPackages'] = 'ComposerPackages\Specials\ListComposerPackages';

// Api
$GLOBALS['wgAPIModules']['composerpackages'] = 'ComposerPackages\Api\ComposerPackages';

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

	$services->registerObject( 'TextBuilder', function ( $builder ) {
		return new \ComposerPackages\TextBuilder(
			$builder->newObject( 'ContentMapper' ),
			$builder->newObject( 'MessageBuilder' )
		);
	} );

	return true;
};