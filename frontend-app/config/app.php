<?php
/**
 * app.php
 * @author Revin Roman
 * @link https://rmrevin.com
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
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => [
        'account', 'page', 'media', 'postman',
        'log', 'rollbar',
    ],
    'modules' => [
        'account' => cookyii\modules\Account\frontend\Module::className(),
        'page' => cookyii\modules\Page\frontend\Module::className(),
        'media' => cookyii\modules\Media\Module::className(),
        'postman' => [
            'class' => cookyii\modules\Postman\frontend\Module::className(),
            'subjectPrefix' => 'Cookyii //',
        ],
    ],
    'components' => [
        'db' => $params['component.db'],
        'mailer' => $params['component.mailer'],
        'request' => $params['component.request'],
        'security' => $params['component.security'],
        'session' => $params['component.session'],
        'user' => $params['component.user'],
        'cache' => $params['component.cache'],
        'cache.authManager' => $params['component.cache.authManager'],
        'cache.schema' => $params['component.cache.schema'],
        'cache.query' => $params['component.cache.query'],
        'assetManager' => $params['component.assetManager'],
        'urlManager' => $params['component.urlManager.frontend'],
        'urlManager.frontend' => $params['component.urlManager.frontend'],
        'urlManager.backend' => $params['component.urlManager.backend'],
        'urlManager.crm' => $params['component.urlManager.crm'],
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
    'on beforeRequest' => function ($event) {
        \cookyii\Config::loadTimeZone();
    },
]);