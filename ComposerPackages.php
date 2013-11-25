<?php

/**
 * Initialization
 *
 * @author mwjames
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

define( 'COMPOSERPACKAGES_VERSION', '0.1' );

$wgExtensionCredits['other'][] = array(
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

$wgAutoloadClasses['ComposerPackages\PackagesFile']        = $dir . '/src/ComposerPackages/PackagesFile.php';
$wgAutoloadClasses['ComposerPackages\ArrayMapper']         = $dir . '/src/ComposerPackages/ArrayMapper.php';
$wgAutoloadClasses['ComposerPackages\PackagesFileReader']  = $dir . '/src/ComposerPackages/PackagesFileReader.php';
$wgAutoloadClasses['ComposerPackages\TextBuilder']         = $dir . '/src/ComposerPackages/TextBuilder.php';
$wgAutoloadClasses['ComposerPackages\MessageBuilder']      = $dir . '/src/ComposerPackages/MessageBuilder.php';

$wgAutoloadClasses['ComposerPackages\Specials\ListComposerPackages'] = $dir . '/src/ComposerPackages/Specials/ListComposerPackages.php';

// Special page
$wgSpecialPages['ListComposerPackages'] = 'ComposerPackages\Specials\ListComposerPackages';

