[![Build Status](https://travis-ci.org/mwjames/composer-packages.png?branch=master)](https://travis-ci.org/mwjames/composer-packages)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/mwjames/composer-packages/badges/quality-score.png?s=e683de3d75d834ef510a9fe21ebdc9bceb6c4b9c)](https://scrutinizer-ci.com/g/mwjames/composer-packages/)

Requires MediaWiki 1.20 or later.

A simple extension that deploys a <code>Special:ListComposerPackages</code> page in order to display information about which composer packages are installed and used within MediaWiki.

## WebApi
An interface to access installed composer packages.

> api.php?action=composerpackages

## Installation
The recommended way to install this extension is through `Composer`. Just add the following to the MediaWiki ``composer.json`` file and run the ``php composer.phar install/update`` command.

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
A manual installation will be insufficient due to usage of the Composer autoloader. For more information about how to use MediaWiki and [Composer][composer], see [here][mwcomposer].

[composer]: http://getcomposer.org/
[mwcomposer]: https://www.mediawiki.org/wiki/Composer