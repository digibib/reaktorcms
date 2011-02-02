#!/bin/sh
# apply the patches:
# Global patches 4 symfony

SYMFONY_DATA_DIR="/usr/share/php/data/symfony"
SYMFONY_LIB_DIR="/usr/share/php/symfony"

#SYMFONY_LIB_DIR="/opt/symfony-1.0/lib"
#SYMFONY_DATA_DIR="/opt/symfony-1.0/data"

REAKTOR_DIR="/opt/reaktor"

patch ${SYMFONY_DATA_DIR}/generator/sfPropelAdmin/default/template/actions/actions.class.php < sfPropelAdmin.patch
patch ${SYMFONY_LIB_DIR}/generator/sfAdminGenerator.class.php < sfAdminGenerator.class.php.patch
patch ${SYMFONY_LIB_DIR}/controller/sfRouting.class.php < sfRouting.patch
patch ${SYMFONY_LIB_DIR}/i18n/sfMessageSource_MySQL.class.php < sfMessageSource_MySQL.class.php.patch
patch ${SYMFONY_LIB_DIR}/i18n/sfMessageSource_MySQL.class.php < sfMessageSource_MySQL.class.php.utf8.patch

# Local patches
patch ${REAKTOR_DIR}/apps/reaktor/config/app.yml < app_google_analytics.patch
patch ${REAKTOR_DIR}/apps/reaktor/config/app.yml < recapcha.patch