<?php

$baseDir = realpath(__DIR__ . '/../..');

require($baseDir . '/vendor/autoload.php');

require($baseDir . '/backend-app/credentials.php');
require($baseDir . '/env.php');

cookyii\Config::requireGlobals($baseDir);

require($baseDir . '/vendor/yiisoft/yii2/Yii.php');
require($baseDir . '/common/config/aliases.php');

cookyii\Config::init('backend', 'app');

(new yii\web\Application(cookyii\Config::$config))
    ->run();