<?php

if ( defined( 'EXTENSION_MANAGER_VERSION' ) ) {
	// Do not initialize more than once.
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
		'url' => 'https://github.com/SemanticMediaWiki/ExtensionManager',
		'descriptionmsg'  => 'extension-manager-description',
	);

	// TODO: migrate to JSON i18n
	$GLOBALS['wgExtensionMessagesFiles']['ExtensionManager']      = __DIR__ . '/' . 'ExtensionManager.i18n.php';
	$GLOBALS['wgExtensionMessagesFiles']['ExtensionManagerAlias'] = __DIR__ . '/' . 'ExtensionManager.alias.php';

	$GLOBALS['wgSpecialPages']['ListComposerPackages'] = 'ExtensionManager\MediaWiki\Specials\ListComposerPackages';

	$GLOBALS['wgAPIModules']['composerpackages'] = 'ExtensionManager\MediaWiki\Api\ComposerPackages';
}
