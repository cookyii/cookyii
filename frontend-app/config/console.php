<?php
/**
 * console.php
 * @author Revin Roman
 */

defined('APP_NAME') or define('APP_NAME', 'Cookyii Base App frontend');

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

$params['component.i18n']['translations'] = include(__DIR__ . '/translations.php');

return [
    'id' => 'frontend-console-app',
    'name' => APP_NAME,
    'basePath' => dirname(__DIR__),
    'aliases' => ['@tests' => '@frontend/tests'],
    'controllerNamespace' => 'frontend\commands',
    'controllerMap' => [
        'rbac' => 'frontend\commands\RbacCommand',
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
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
        'urlManager' => $params['component.urlManager.frontend'],
        'urlManager.backend' => $params['component.urlManager.backend'],
        'authManager' => $params['component.authManager'],
        'i18n' => $params['component.i18n'],
        'log' => $params['component.log'],
    ],
    'params' => $params,
];
