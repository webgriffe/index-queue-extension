#!/bin/sh

export magento_dir=magento
export db_host=127.0.0.1
export db_user=root
export db_pass=p4ssw0rd
export db_name=index-queue-extension-ci
export db_test_name=${db_name}_test
export install_sample_data=no
export base_url=http://index-queue-extension.mage.dev/
export phpunit_filter=Webgriffe_IndexQueue

export MAGENTO_VERSION=magento-ce-1.8.1.0

export TRAVIS_BUILD_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

sh ci-install.sh
sh ci-test.sh