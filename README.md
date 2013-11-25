A simple extension that deploys a <code>Special:ListComposerPackages</code> page in order to display information about which composer packages are installed and used within MediaWiki.

For more information about how to use MediaWiki and [Composer][composer], see [here][mwcomposer].

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

[composer]: http://getcomposer.org/
[mwcomposer]: https://www.mediawiki.org/wiki/Composer