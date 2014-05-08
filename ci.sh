#!/bin/sh

source ./params.sh

export magento_dir=magento
export phpunit_filter=Webgriffe_IndexQueue

export MAGENTO_VERSION=magento-ce-1.8.1.0

export TRAVIS_BUILD_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

sh ci-install.sh
sh ci-test.sh