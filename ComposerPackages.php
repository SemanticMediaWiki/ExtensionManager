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
	'url'             => 'https://github.com/mwjames/mw-composerpackages',
	'descriptionmsg'  => 'composerpackages-desc',
);

$dir = __DIR__ . '/';

// Message class
$GLOBALS['wgExtensionMessagesFiles']['ComposerPackages']      = $dir . 'ComposerPackages.i18n.php';
$GLOBALS['wgExtensionMessagesFiles']['ComposerPackagesAlias'] = $dir . 'ComposerPackages.alias.php';

$GLOBALS['wgAutoloadClasses']['ComposerPackages\PackagesFile']        = $dir . '/src/ComposerPackages/PackagesFile.php';
$GLOBALS['wgAutoloadClasses']['ComposerPackages\ArrayMapper']         = $dir . '/src/ComposerPackages/ArrayMapper.php';
$GLOBALS['wgAutoloadClasses']['ComposerPackages\PackagesFileReader']  = $dir . '/src/ComposerPackages/PackagesFileReader.php';
$GLOBALS['wgAutoloadClasses']['ComposerPackages\TextBuilder']         = $dir . '/src/ComposerPackages/TextBuilder.php';
$GLOBALS['wgAutoloadClasses']['ComposerPackages\MessageBuilder']      = $dir . '/src/ComposerPackages/MessageBuilder.php';

$GLOBALS['wgAutoloadClasses']['ComposerPackages\Specials\ListComposerPackages'] = $dir . '/src/ComposerPackages/Specials/ListComposerPackages.php';

// Special page
$GLOBALS['wgSpecialPages']['ListComposerPackages'] = 'ComposerPackages\Specials\ListComposerPackages';

