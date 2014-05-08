#!/bin/sh

source ./params.sh
export db_host=${db_host}
export db_user=${db_user}
export db_pass=${db_pass}
export db_name=${db_name}
export base_url=${base_url}
export db_test_name=${db_test_name}
export install_sample_data=${install_sample_data}

export magento_dir=magento
export phpunit_filter=Webgriffe_IndexQueue

export MAGENTO_VERSION=magento-ce-1.8.1.0

export TRAVIS_BUILD_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

sh ci-install.sh
sh ci-test.sh