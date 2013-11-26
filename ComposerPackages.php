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
