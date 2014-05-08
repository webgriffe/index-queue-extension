#!/bin/sh

source ./params.sh
mysql -u root -pp4ssw0rd -e "DROP DATABASE \`${db_name}\`; DROP DATABASE \`${db_test_name}\`;"
rm -Rf .modman
rm -Rf magento
rm -Rf vendor
rm modman.sh
rm n98-magerun.phar