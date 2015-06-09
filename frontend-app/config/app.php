<?php
/**
 * app.php
 * @author Revin Roman http://phptime.ru
 */

defined('APP_NAME') or define('APP_NAME', 'Cookyii Base App frontend');

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

// переключение на тестовую БД, если сайт дергает codeception
$isTestExecute = isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] === 'Symfony2 BrowserKit';
$component_db = $params['component.db.production'];
$component_db_test = $params['component.db.test'];
if ($isTestExecute) {
    $component_db = $component_db_test;
}

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
        'db' => $component_db,
        'db.test' => $component_db_test,
        'session' => $params['component.session'],
        'security' => $params['component.security'],
        'user' => $params['component.user'],
        'postman' => $params['component.postman'],
        'authManager' => $params['component.authManager'],
        'assetManager' => $params['component.assetManager'],
        'urlManager.crm' => $params['component.urlManager.crm'],
        'urlManager' => $params['component.urlManager.frontend'],
        'urlManager.backend' => $params['component.urlManager.backend'],
        'view' => $params['component.view'],
        'i18n' => $params['component.i18n'],
        'formatter' => $params['component.formatter'],
        'cache' => $params['component.cache'],
        'cache.session' => $params['component.cache.session'],
        'cache.authManager' => $params['component.cache.authManager'],
        'cache.schema' => $params['component.cache.schema'],
        'cache.query' => $params['component.cache.query'],
        'errorHandler' => $params['component.errorHandler'],
        'log' => $params['component.log'],
        'request' => $params['component.request'],
    ],
    'params' => $params,
];
