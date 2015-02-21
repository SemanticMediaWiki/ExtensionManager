#! /bin/bash

set -x

cd ../phase3/extensions/ExtensionManager

php ../../tests/phpunit/phpunit.php -c phpunit.xml.dist