<?php

if ( defined( 'EXTENSION_MANAGER_VERSION' ) ) {
	return 1;
}

define( 'EXTENSION_MANAGER_VERSION', '0.1 alpha' );

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	include_once( __DIR__ . '/vendor/autoload.php' );
}

if ( defined( 'MEDIAWIKI' ) ) {
	$GLOBALS['wgExtensionCredits']['other'][] = array(
		'path'            => __FILE__,
		'name'            => 'Extension Manager',
		'version'         => EXTENSION_MANAGER_VERSION,
		'author'          => array(
			'mwjames',
			'Jeroen De Dauw'
		),
		// TODO: url
		'descriptionmsg'  => 'extension-manager-description',
	);

	// Message class
	$GLOBALS['wgExtensionMessagesFiles']['ExtensionManager']      = __DIR__ . '/' . 'ExtensionManager.i18n.php';
	$GLOBALS['wgExtensionMessagesFiles']['ExtensionManagerAlias'] = __DIR__ . '/' . 'ExtensionManager.alias.php';

	// Special page
	$GLOBALS['wgSpecialPages']['ListComposerPackages'] = 'ExtensionManager\MediaWiki\Specials\ListComposerPackages';

	// Api
	$GLOBALS['wgAPIModules']['composerpackages'] = 'ExtensionManager\MediaWiki\Api\ComposerPackages';

	ServiceRegistry\ServiceRegistry::getInstance( 'composerpackages' )->registerContainer(
		new ExtensionManager\DIC\ServicesContainer( $GLOBALS['IP'], 'composer.lock' )
	);
}
