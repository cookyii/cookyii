<?php
/**
 * _bootstrap.php
 * @author Revin Roman http://phptime.ru
 */

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', dirname(dirname(__DIR__)));

defined('ERP_ENTRY_URL') or define('ERP_ENTRY_URL', \Codeception\Configuration::config()['config']['test_entry_url']);
defined('ERP_ENTRY_FILE') or define('ERP_ENTRY_FILE', YII_APP_BASE_PATH . '/erp-app/web/index-test.php');

require_once(YII_APP_BASE_PATH . '/.environment.php');
require_once(YII_APP_BASE_PATH . '/vendor/autoload.php');
require_once(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/Yii.php');
require(YII_APP_BASE_PATH . '/common/config/aliases.php');

// set correct script paths

// the entry script file path for functional and acceptance tests
$_SERVER['SCRIPT_FILENAME'] = ERP_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = ERP_ENTRY_URL;
$_SERVER['SERVER_NAME'] = 'erp.evrogen.lc';

Yii::setAlias('@tests', __DIR__);