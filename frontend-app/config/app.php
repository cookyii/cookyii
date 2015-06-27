<?php
/**
 * app.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

defined('APP_NAME') or define('APP_NAME', 'Cookyii Frontend');

$config = require(__DIR__ . '/../../common/config/app.php');

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return array_merge($config, [
    'id' => 'frontend-app',
    'name' => APP_NAME,
    'basePath' => dirname(__DIR__),
    'extensions' => array_merge($config['extensions'], include __DIR__ . '/../../.extensions.php'),
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => [
        'page', 'media',
        'log', 'rollbar',
    ],
    'modules' => [
        'page' => cookyii\modules\Page\frontend\Module::className(),
        'media' => cookyii\modules\Media\Module::className(),
    ],
    'components' => [
        'db' => $params['component.db'],
        'mailer' => $params['component.mailer'],
        'request' => $params['component.request.frontend'],
        'security' => $params['component.security'],
        'session' => $params['component.session'],
        'user' => $params['component.user'],
        'cache' => $params['component.cache'],
        'cache.authManager' => $params['component.cache.authManager'],
        'cache.schema' => $params['component.cache.schema'],
        'cache.query' => $params['component.cache.query'],
        'assetManager' => $params['component.assetManager'],
        'urlManager' => $params['component.urlManager.frontend'],
        'urlManager.backend' => $params['component.urlManager.backend'],
        'authManager' => $params['component.authManager'],
        'i18n' => $params['component.i18n'],
        'formatter' => $params['component.formatter'],
        'view' => $params['component.view'],
        'log' => $params['component.log'],
        'rollbar' => $params['component.rollbar'],
        'errorHandler' => [
            'class' => rmrevin\yii\rollbar\web\ErrorHandler::className(),
            'errorAction' => 'site/error'
        ],
    ],
    'params' => $params,
]);