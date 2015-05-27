<?php
/**
 * console.php
 * @author Revin Roman http://phptime.ru
 */

defined('APP_NAME') or define('APP_NAME', 'Cookyii Base App backend');

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$params['component.urlManager']['rules'] = require(__DIR__ . '/urls.php');

return [
    'id' => 'backend-console-app',
    'name' => APP_NAME,
    'basePath' => dirname(__DIR__),
    'aliases' => ['@tests' => '@backend/tests'],
    'controllerNamespace' => 'backend\commands',
    'controllerMap' => [
        'rbac' => backend\commands\RbacCommand::class,
        'migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'templateFile' => '@common/views/migration.php',
            'migrationPath' => '@common/migrations',
        ],
    ],
    'modules' => [],
    'components' => [
        'db' => $params['component.db.production'],
        'db.test' => $params['component.db.test'],
        'security' => $params['component.security'],
        'user' => $params['component.user'],
        'postman' => $params['component.postman'],
        'cache' => $params['component.cache'],
        'cache.session' => $params['component.cache.session'],
        'cache.authManager' => $params['component.cache.authManager'],
        'cache.schema' => $params['component.cache.schema'],
        'cache.query' => $params['component.cache.query'],
        'urlManager.crm' => $params['component.urlManager.crm'],
        'urlManager.frontend' => $params['component.urlManager.frontend'],
        'urlManager' => $params['component.urlManager.backend'],
        'authManager' => $params['component.authManager'],
        'i18n' => $params['component.i18n'],
        'log' => $params['component.log'],
    ],
    'params' => $params,
];
