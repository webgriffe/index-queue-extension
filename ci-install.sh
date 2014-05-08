#!/bin/sh

cd ${TRAVIS_BUILD_DIR} && pwd
wget https://raw.github.com/netz98/n98-magerun/master/n98-magerun.phar
php n98-magerun.phar install --installationFolder=${magento_dir} --dbHost=${db_host} --dbUser=${db_user} --dbPass=${db_pass} --dbName=${db_name} --installSampleData=${install_sample_data} --useDefaultConfigParams=yes --magentoVersionByName=${MAGENTO_VERSION} --baseUrl=${base_url}
cd ${magento_dir} && php ${TRAVIS_BUILD_DIR}/n98-magerun.phar cache:clean && cd ${TRAVIS_BUILD_DIR}
cd ${magento_dir} && php ${TRAVIS_BUILD_DIR}/n98-magerun.phar cache:disable && cd ${TRAVIS_BUILD_DIR}
composer install
mysql -uroot --password="${db_pass}" -e "CREATE DATABASE \`${db_test_name}\`"
cd ${magento_dir}/shell && php ecomdev-phpunit.php --action install && cd ${TRAVIS_BUILD_DIR}
cd ${magento_dir}/shell && php ecomdev-phpunit.php --action change-status && cd ${TRAVIS_BUILD_DIR}
cd ${magento_dir}/shell && php ecomdev-phpunit.php --action magento-config --db-name ${db_test_name} --base-url ${base_url} && cd ${TRAVIS_BUILD_DIR}
wget https://raw.githubusercontent.com/colinmollenhour/modman/master/modman -O modman.sh
chmod a+x ${TRAVIS_BUILD_DIR}/modman.sh
${TRAVIS_BUILD_DIR}/modman.sh init magento
${TRAVIS_BUILD_DIR}/modman.sh link ${TRAVIS_BUILD_DIR}
