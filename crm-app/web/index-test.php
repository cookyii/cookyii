<?php
// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

$baseDir = realpath(__DIR__ . '/../..');

require($baseDir . '/crm-app/credentials.php');
require($baseDir . '/env.php');

require($baseDir . '/vendor/autoload.php');
require($baseDir . '/vendor/yiisoft/yii2/Yii.php');

require($baseDir . '/common/config/bootstrap.php');
require($baseDir . '/crm-app/config/bootstrap.php');

\cookyii\Config::requireGlobals($baseDir);

$config = require($baseDir . '/crm-app/tests/_config/acceptance.php');

(new yii\web\Application($config))
    ->run();