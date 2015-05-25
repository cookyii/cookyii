<?php
/**
 * console.php
 * @author Revin Roman http://phptime.ru
 */

defined('APP_NAME') or define('APP_NAME', 'Application Name');

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$params['component.urlManager']['rules'] = require(__DIR__ . '/urls.php');

return [
    'id' => 'crm-console-app',
    'name' => APP_NAME,
    'basePath' => dirname(__DIR__),
    'aliases' => ['@tests' => '@crm/tests'],
    'controllerNamespace' => 'crm\commands',
    'controllerMap' => [
        'rbac' => crm\commands\RbacCommand::class,
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
        'urlManager' => $params['component.urlManager.crm'],
        'urlManager.cake' => $params['component.urlManager.cake'],
        'authManager' => $params['component.authManager'],
        'i18n' => $params['component.i18n'],
        'log' => $params['component.log'],
    ],
    'params' => $params,
];
