<?php

use ServiceRegistry\ServiceRegistry;
use ExtensionManager\ServicesContainer;

if ( defined( 'EXTENSION_MANAGER_VERSION' ) ) {
	return 1;
}

define( 'EXTENSION_MANAGER_VERSION', '0.1' );

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	include_once( __DIR__ . '/vendor/autoload.php' );
}

if ( defined( 'MEDIAWIKI' ) ) {
	$GLOBALS['wgExtensionCredits']['other'][] = array(
		'path'            => __FILE__,
		'name'            => 'Extension Manager',
		'version'         => EXTENSION_MANAGER_VERSION,
		'author'          => array( 'mwjames' ),
		'url'             => 'https://github.com/mwjames/composer-packages',
		'descriptionmsg'  => 'composerpackages-desc',
	);

	// Message class
	$GLOBALS['wgExtensionMessagesFiles']['ExtensionManager']      = __DIR__ . '/' . 'ExtensionManager.i18n.php';
	$GLOBALS['wgExtensionMessagesFiles']['ExtensionManagerAlias'] = __DIR__ . '/' . 'ExtensionManager.alias.php';

	// Special page
	$GLOBALS['wgSpecialPages']['ListComposerPackages'] = 'ExtensionManager\Specials\ListComposerPackages';

	// Api
	$GLOBALS['wgAPIModules']['composerpackages'] = 'ExtensionManager\Api\ComposerPackages';

	ServiceRegistry::getInstance( 'composerpackages' )->registerContainer(
		new ServicesContainer( __DIR__, 'composer.lock' )
	);
}
