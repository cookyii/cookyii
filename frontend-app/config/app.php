<?php
/**
 * app.php
 * @author Revin Roman
 */

defined('APP_NAME') or define('APP_NAME', 'Cookyii Base App frontend');

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

$params['component.i18n']['translations'] = include(__DIR__ . '/translations.php');

return [
    'id' => 'frontend-app',
    'name' => APP_NAME,
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
    ],
    'components' => [
        'db' => $params['component.db'],
        'session' => $params['component.session'],
        'security' => $params['component.security'],
        'user' => $params['component.user'],
        'authManager' => $params['component.authManager'],
        'assetManager' => $params['component.assetManager'],
        'urlManager' => $params['component.urlManager.frontend'],
        'urlManager.backend' => $params['component.urlManager.backend'],
        'view' => $params['component.view'],
        'i18n' => $params['component.i18n'],
        'formatter' => $params['component.formatter'],
        'cache' => $params['component.cache'],
        'cache.authManager' => $params['component.cache.authManager'],
        'cache.schema' => $params['component.cache.schema'],
        'cache.query' => $params['component.cache.query'],
        'errorHandler' => $params['component.errorHandler'],
        'log' => $params['component.log'],
        'request' => $params['component.request.frontend'],
    ],
    'params' => $params,
];
