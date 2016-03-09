#!/usr/bin/env bash

export SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )" # Do not edit this line

export db_host="localhost"                           # MySQL Database Host
export db_user="root"                           # MySQL Database User
export db_pass=""                           # MySQL Database Password
export db_name="tmpdb"                           # MySQL Database Name
export db_test_name="tmpdb-test"                      # MySQL Test Database Name
export base_url="http://127.0.0.1:8000/"                          # Magento base URL (remember the trailing slash)
export install_sample_data="no"             # Install sample data ('yes' or 'no')

export magento_dir="magento"                # Magento directory name without heading or trailing slashes
export MBC_PHPUNIT_ARGS="--filter Webgriffe_IndexQueue" # [OPTIONAL] Arguments for PHPUnit command (e.g. "--log-junit junit.xml")

# export MAGENTO_VERSION="magento-mirror-1.9.2.2" -> Exported by Travis...

export BASE_DIR="${SCRIPT_DIR}"                          # Absolute path of the directory where composer.json is located
export CI_LIB_DIR="${BASE_DIR}/magento-bash-ci"          # Absolute path of the directory where are located CI scripts

sh ${CI_LIB_DIR}/ci-install.sh
sh ${CI_LIB_DIR}/ci-test.sh
