#!/bin/sh
cd ${TRAVIS_BUILD_DIR}/${magento_dir} && pwd
${TRAVIS_BUILD_DIR}/vendor/bin/phpunit --version
${TRAVIS_BUILD_DIR}/vendor/bin/phpunit --filter ${phpunit_filter}
