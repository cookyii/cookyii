<?php

$baseDir = realpath(__DIR__ . '/../..');

require($baseDir . '/crm-app/credentials.php');
require($baseDir . '/env.php');

require($baseDir . '/vendor/autoload.php');
require($baseDir . '/vendor/yiisoft/yii2/Yii.php');

require($baseDir . '/common/config/bootstrap.php');
require($baseDir . '/crm-app/config/bootstrap.php');

\cookyii\Config::requireGlobals($baseDir);
\cookyii\Config::init('crm', 'app');

(new yii\web\Application(\cookyii\Config::$config))
    ->run();