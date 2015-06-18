<?php

require(__DIR__ . '/../../vendor/autoload.php');

require(__DIR__ . '/../credentials.php');
require(__DIR__ . '/../../env.php');
require(__DIR__ . '/../../globals.php');

require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/aliases.php');

components\Config::init('frontend', 'app');

(new yii\web\Application(components\Config::$config))
    ->run();