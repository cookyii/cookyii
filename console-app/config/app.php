<?php
/**
 * app.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

$config = require(__DIR__ . '/../../common/config/app.php');

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return array_merge($config, [
    'id' => 'console-app',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'account' => cookyii\modules\Account\commands\AccountCommand::className(),
        'postman' => cookyii\modules\Postman\commands\PostmanCommand::className(),
        'migrate' => [
            'class' => cookyii\console\controllers\MigrateController::className(),
            'templateFile' => '@console/views/migration.php',
        ],
    ],
    'bootstrap' => ['log'],
    'components' => [
        'db' => $params['component.db'],
        'security' => $params['component.security'],
        'user' => $params['component.user'],
        'cache' => $params['component.cache'],
        'cache.authManager' => $params['component.cache.authManager'],
        'cache.schema' => $params['component.cache.schema'],
        'cache.query' => $params['component.cache.query'],
        'urlManager.frontend' => $params['component.urlManager.frontend'],
        'urlManager.backend' => $params['component.urlManager.backend'],
        'urlManager.crm' => $params['component.urlManager.crm'],
        'authManager' => $params['component.authManager'],
        'i18n' => $params['component.i18n'],
        'formatter' => $params['component.formatter'],
        'log' => $params['component.log'],
        'errorHandler' => [
            'class' => yii\console\ErrorHandler::className(),
        ],
    ],
    'params' => $params,
]);