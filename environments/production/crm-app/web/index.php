<?php

require(__DIR__ . '/../../.environment.php');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/aliases.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/app.php'),
    require(__DIR__ . '/../../common/config/app-local.php'),
    require(__DIR__ . '/../config/app.php'),
    require(__DIR__ . '/../config/app-local.php')
);

(new yii\web\Application($config))->run();