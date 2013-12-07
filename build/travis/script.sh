#! /bin/bash

set -x

cd ../phase3/extensions/ExtensionManager

if [ "$MW-$DBTYPE" == "master-mysql" ]
then
	phpunit --coverage-clover ../../extensions/ExtensionManager/build/logs/clover.xml
else
	phpunit
fi