<?php
/**
 * app.php
 * @author Revin Roman
 */

defined('APP_NAME') or define('APP_NAME', 'Cookyii Backend');

$config = require(__DIR__ . '/../../common/config/app.php');

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return array_merge($config, [
    'id' => 'backend-app',
    'name' => APP_NAME,
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
        'account',
        'cookyii\modules\Page\backend\Bootstrap',
        'cookyii\modules\Media\Bootstrap',
        'log',
    ],
    'modules' => [
        'page' => cookyii\modules\Page\backend\Module::className(),
        'account' => cookyii\modules\Account\backend\Module::className(),
        'media' => cookyii\modules\Media\Module::className(),
    ],
    'components' => [
        'db' => $params['component.db'],
        'session' => $params['component.session'],
        'security' => $params['component.security'],
        'user' => $params['component.user'],
        'authManager' => $params['component.authManager'],
        'assetManager' => $params['component.assetManager'],
        'urlManager.frontend' => $params['component.urlManager.frontend'],
        'urlManager' => $params['component.urlManager.backend'],
        'request' => $params['component.request.backend'],
        'view' => $params['component.view'],
        'i18n' => $params['component.i18n'],
        'formatter' => $params['component.formatter'],
        'cache' => $params['component.cache'],
        'cache.authManager' => $params['component.cache.authManager'],
        'cache.schema' => $params['component.cache.schema'],
        'cache.query' => $params['component.cache.query'],
        'errorHandler' => $params['component.errorHandler'],
        'log' => $params['component.log'],
        'authClientCollection' => $params['component.authClientCollection'],
    ],
    'params' => $params,
]);