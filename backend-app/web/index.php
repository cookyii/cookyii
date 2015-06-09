<?php

require(__DIR__ . '/../../vendor/autoload.php');

require(__DIR__ . '/../../env.php');
require(__DIR__ . '/../../globals.php');

require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/aliases.php');

common\components\Config::init('backend', 'app');

(new yii\web\Application(common\components\Config::$config))
    ->run();