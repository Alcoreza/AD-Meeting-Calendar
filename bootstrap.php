<?php
if (!defined('BASE_PATH'))
    define('BASE_PATH', realpath(__DIR__));
if (!defined('UTILS_PATH'))
    define('UTILS_PATH', BASE_PATH . '/utils/');
if (!defined('VENDOR_PATH'))
    define('VENDOR_PATH', BASE_PATH . '/vendor/');
if (!defined('HANDLERS_PATH'))
    define('HANDLERS_PATH', BASE_PATH . '/handlers/');
if (!defined('DUMMIES_PATH'))
    define('DUMMIES_PATH', BASE_PATH . '/staticDatas/dummies/');
if (!defined('BOOTSTRAP_PATH'))
    define('BOOTSTRAP_PATH', BASE_PATH . '/bootstrap.php');
if (!defined('LOGIN_URL'))
    define('LOGIN_URL', '/pages/Login/login.php');
if (!defined('COMPONENTS_PATH'))
    define('COMPONENTS_PATH', BASE_PATH . '/components/componentGroup/');
if (!defined('LAYOUTS_PATH'))
    define('LAYOUTS_PATH', BASE_PATH . '/layouts/');

chdir(BASE_PATH);

