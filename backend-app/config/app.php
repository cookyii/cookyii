<?php
/**
 * app.php
 * @author Revin Roman
 * @link https://rmrevin.ru
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
    'extensions' => array_merge($config['extensions'], include __DIR__ . '/../../.extensions.php'),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
        'account',
        'page',
        'postman',
        'media',
        'log',
        'rollbar',
    ],
    'modules' => [
        'page' => cookyii\modules\Page\backend\Module::className(),
        'account' => cookyii\modules\Account\backend\Module::className(),
        'postman' => cookyii\modules\Postman\backend\Module::className(),
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
        'urlManager.frontend' => $params['component.urlManager.frontend'],
        'urlManager' => $params['component.urlManager.backend'],
        'authManager' => $params['component.authManager'],
        'authClientCollection' => $params['component.authClientCollection'],
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