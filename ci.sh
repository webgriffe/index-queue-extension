#!/bin/sh

BASEDIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Magento install (n98) in "magento" dir
composer install
modman init magento
modman link ${BASEDIR}



