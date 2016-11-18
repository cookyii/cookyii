<?php
/**
 * app.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

$config = require(__DIR__ . '/../../common/config/app.php');

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

$params['module.postman']['class'] = cookyii\modules\Postman\backend\Module::class;

return array_merge($config, [
    'id' => 'backend-app',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'feed' => cookyii\modules\Feed\backend\Module::class,
        'page' => cookyii\modules\Page\backend\Module::class,
        'client' => cookyii\modules\Client\backend\Module::class,
        'translation' => cookyii\modules\Translation\backend\Module::class,
        'media' => $params['module.media'],
        'postman' => $params['module.postman'],
        'account' => [
            'class' => cookyii\modules\Account\backend\Module::class,
            'roles' => [
                'admin' => \common\Roles::ADMIN,
                'user' => \common\Roles::USER,
            ],
        ],
    ],
    'components' => [
        'db' => $params['component.db'],
//        'redis' => $params['component.redis'],
//        'queue' => $params['component.queue'],
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
        'urlManager' => $params['component.urlManager.backend'],
        'urlManager.frontend' => $params['component.urlManager.frontend'],
        'urlManager.backend' => $params['component.urlManager.backend'],
        'authManager' => $params['component.authManager'],
        'authClientCollection' => $params['component.authClientCollection'],
        'i18n' => $params['component.i18n'],
        'formatter' => $params['component.formatter'],
        'view' => $params['component.view'],
        'log' => $params['component.log'],
        'errorHandler' => [
            'class' => cookyii\web\ErrorHandler::class,
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
    'on beforeRequest' => function ($event) {
        \cookyii\Config::loadTimeZone();
    },
]);