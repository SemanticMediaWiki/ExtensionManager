[![Build Status](https://travis-ci.org/mwjames/composer-packages.png?branch=master)](https://travis-ci.org/mwjames/composer-packages)

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
			"url":  "git@github.com:mwjames/composer-packages.git"
		}
	],
	"minimum-stability" : "dev"
}
```
A manual installation will be insufficient due to usage of the Composer autoloader. For more information about how to use MediaWiki and [Composer][composer], see [here][mwcomposer].

[composer]: http://getcomposer.org/
[mwcomposer]: https://www.mediawiki.org/wiki/Composer