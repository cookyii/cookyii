<?php

$baseDir = realpath(__DIR__ . '/../..');

require($baseDir . '/backend-app/credentials.php');
require($baseDir . '/env.php');

require($baseDir . '/vendor/autoload.php');
require($baseDir . '/vendor/yiisoft/yii2/Yii.php');

require($baseDir . '/common/config/bootstrap.php');
require($baseDir . '/backend-app/config/bootstrap.php');

\cookyii\Config::requireGlobals($baseDir);
\cookyii\Config::init('backend', 'app');

(new yii\web\Application(\cookyii\Config::$config))
    ->run();