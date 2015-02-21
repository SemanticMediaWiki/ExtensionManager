[![Build Status](https://secure.travis-ci.org/SemanticMediaWiki/ExtensionManager.svg?branch=master)](http://travis-ci.org/SemanticMediaWiki/ExtensionManager)
[![Code Coverage](https://scrutinizer-ci.com/g/SemanticMediaWiki/ExtensionManager/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/SemanticMediaWiki/ExtensionManager/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SemanticMediaWiki/ExtensionManager/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SemanticMediaWiki/ExtensionManager/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/mediawiki/extension-manager/version.png)](https://packagist.org/packages/mediawiki/extension-manager)
[![Packagist download count](https://poser.pugx.org/mediawiki/extension-manager/d/total.png)](https://packagist.org/packages/mediawiki/extension-manager)
[![Dependency Status](https://www.versioneye.com/php/mediawiki:extension-manager/badge.png)](https://www.versioneye.com/php/mediawiki:extension-manager)


Requires MediaWiki 1.20 or later.

A simple extension that deploys a <code>Special:ListComposerPackages</code> page in order to display
information about which composer packages are installed and used within MediaWiki.

## WebApi
An interface to access installed composer packages.

> api.php?action=composerpackages

## Installation
The recommended way to install this extension is through `Composer`. Just add the following to the
MediaWiki ``composer.json`` file and run the ``php composer.phar install/update`` command.

```json
{
	"require": {
		"mwjames/composer-packages": "dev-master"
	},
	"repositories": [
		{
			"type": "vcs",
			"url":  "https://github.com/mwjames/composer-packages"
		}
	],
	"minimum-stability" : "dev"
}
```
A manual installation will be insufficient due to usage of the Composer autoloader. For more
information about how to use MediaWiki and [Composer][composer], see [here][mwcomposer].

[composer]: http://getcomposer.org/
[mwcomposer]: https://www.mediawiki.org/wiki/Composer