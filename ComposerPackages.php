<?php

use ServiceRegistry\ServiceRegistry;
use ComposerPackages\ServicesContainer;

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

	// Services registration
	$GLOBALS['wgExtensionFunctions']['composerpackages'] = function() {

		ServiceRegistry::getInstance( 'composerpackages' )->registerContainer(
			new ServicesContainer( $GLOBALS['IP'], 'composer.lock' )
		);

		return true;
	};

}