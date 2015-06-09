<?php
/**
 * functional.php
 * @author Revin Roman http://phptime.ru
 */

$_SERVER['SCRIPT_FILENAME'] = ERP_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = ERP_ENTRY_URL;

$params = array_merge(
    require(YII_APP_BASE_PATH . '/common/config/params.php'),
    require(YII_APP_BASE_PATH . '/common/config/params-local.php'),
    require(YII_APP_BASE_PATH . '/erp-app/config/params.php'),
    require(YII_APP_BASE_PATH . '/erp-app/config/params-local.php')
);

$config = yii\helpers\ArrayHelper::merge(
    require(YII_APP_BASE_PATH . '/common/config/app.php'),
    require(YII_APP_BASE_PATH . '/common/config/app-local.php'),
    require(YII_APP_BASE_PATH . '/erp-app/config/app.php'),
    require(YII_APP_BASE_PATH . '/erp-app/config/app-local.php'),
    [
        'id' => 'test-app',
        'name' => 'Evrogen Automatic Functional Tests',
        'components' => [
            'db' => $params['component.db']['erp.test'], // ТЕСТОВАЯ база данных
        ]
    ]
);

unset($config['modules']['debug'], $config['bootstrap'][array_search('debug', $config['bootstrap'])]);

return $config;