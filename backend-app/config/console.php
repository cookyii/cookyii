<?php
/**
 * console.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

defined('APP_NAME') or define('APP_NAME', 'Cookyii Base App backend');

$config = require(__DIR__ . '/../../common/config/console.php');

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return array_merge($config, [
    'id' => 'backend-console-app',
    'name' => APP_NAME,
    'basePath' => dirname(__DIR__),
    'aliases' => ['@tests' => '@backend/tests'],
    'controllerNamespace' => 'backend\commands',
    'controllerMap' => [
        'account' => cookyii\modules\Account\commands\UserCommand::className(),
        'rbac' => common\commands\RbacCommand::className(),
        'migrate' => [
            'class' => components\console\controllers\MigrateController::className(),
            'templateFile' => '@common/views/migration.php',
            'migrationPath' => '@common/migrations',
        ],
    ],
    'modules' => [],
    'components' => [
        'db' => $params['component.db'],
        'security' => $params['component.security'],
        'user' => $params['component.user'],
        'cache' => $params['component.cache'],
        'cache.authManager' => $params['component.cache.authManager'],
        'cache.schema' => $params['component.cache.schema'],
        'cache.query' => $params['component.cache.query'],
        'urlManager.frontend' => $params['component.urlManager.frontend'],
        'urlManager' => $params['component.urlManager.backend'],
        'authManager' => $params['component.authManager'],
        'i18n' => $params['component.i18n'],
        'log' => $params['component.log'],
    ],
    'params' => $params,
]);