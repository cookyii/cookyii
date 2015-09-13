<?php

$baseDir = realpath(__DIR__ . '/../..');

require($baseDir . '/frontend-app/credentials.php');
require($baseDir . '/env.php');

require($baseDir . '/vendor/autoload.php');
require($baseDir . '/vendor/yiisoft/yii2/Yii.php');

require($baseDir . '/common/config/bootstrap.php');
require($baseDir . '/frontend-app/config/bootstrap.php');

\cookyii\Config::requireGlobals($baseDir);
\cookyii\Config::init('frontend', 'app');

(new yii\web\Application(\cookyii\Config::$config))
    ->run();