<?php

$baseDir = realpath(__DIR__ . '/../..');

require($baseDir . '/vendor/autoload.php');

require($baseDir . '/backend-app/credentials.php');
require($baseDir . '/env.php');

components\Config::requireGlobals($baseDir);

require($baseDir . '/vendor/yiisoft/yii2/Yii.php');
require($baseDir . '/common/config/aliases.php');

components\Config::init('backend', 'app');

(new yii\web\Application(components\Config::$config))
    ->run();