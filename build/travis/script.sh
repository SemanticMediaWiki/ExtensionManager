#! /bin/bash

set -x

cd ../phase3/extensions/ExtensionManager

if [ "$MW-$DBTYPE" == "master-mysql" ]
then
	phpunit -c ../../extensions/ExtensionManager/phpunit.xml.dist --coverage-clover ../../extensions/ExtensionManager/build/logs/clover.xml
else
	phpunit -c ../../extensions/ExtensionManager/phpunit.xml.dist
fi