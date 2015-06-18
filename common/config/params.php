<?php
/**
 * params.php
 * @author Revin Roman
 */

return [
    'component.db' => [
        'class' => yii\db\Connection::className(),
        'charset' => 'utf8',
        'enableSchemaCache' => true,
        'schemaCache' => 'cache.schema',
        'enableQueryCache' => false,
        'queryCache' => 'cache.query',
        'dsn' => getenv('DB_DSN'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASS'),
        'tablePrefix' => 'yii_'
    ],
    'component.session' => [
        'class' => yii\web\DbSession::className(),
    ],
    'component.security' => [
        'class' => yii\base\Security::className(),
    ],
    'component.log' => [
        'class' => yii\log\Dispatcher::className(),
        'targets' => [],
    ],
    'component.view' => [
        'class' => yii\web\View::className(),
    ],
    'component.user' => [
        'class' => yii\web\User::className(),
        'enableAutoLogin' => true,
        'loginUrl' => ['/'],
    ],
    'component.authManager' => [
        'class' => yii\rbac\DbManager::className(),
        'itemTable' => '{{%rbac_item}}',
        'itemChildTable' => '{{%rbac_item_child}}',
        'assignmentTable' => '{{%rbac_assignment}}',
        'ruleTable' => '{{%rbac_rule}}',
        'cache' => 'cache.authManager',
    ],
    'component.cache' => [
        'class' => yii\caching\DbCache::className(),
        'keyPrefix' => 'normal-',
    ],
    'component.cache.authManager' => [
        'class' => yii\caching\ApcCache::className(), // apc cache not available in cli!
        'keyPrefix' => 'authManager-',
    ],
    'component.cache.schema' => [
        'class' => yii\caching\ApcCache::className(), // apc cache not available in cli!
        'keyPrefix' => 'schema-',
    ],
    'component.cache.query' => [
        'class' => yii\caching\DummyCache::className(),
        'keyPrefix' => 'query-',
    ],
    'component.assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
        'linkAssets' => true,
        'bundles' => [
            yii\bootstrap\BootstrapAsset::className() => ['css' => []],
        ],
    ],
    'component.urlManager.frontend' => [
        'class' => yii\web\UrlManager::className(),
        'baseUrl' => '/',
        'hostInfo' => sprintf('http://%s', getenv('FRONTEND_DOMAIN')),
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'cache' => false,
        'rules' => require(\Yii::getAlias('@frontend/config/urls.php')),
    ],
    'component.urlManager.backend' => [
        'class' => yii\web\UrlManager::className(),
        'baseUrl' => '/',
        'hostInfo' => sprintf('http://%s', getenv('BACKEND_DOMAIN')),
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'cache' => false,
        'rules' => require(\Yii::getAlias('@backend/config/urls.php')),
    ],
    'component.errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'component.i18n' => [
    ],
    'component.request.frontend' => [
        'cookieValidationKey' => getenv('FRONTEND_COOKIE_VALIDATION_KEY'),
        'parsers' => ['application/json' => 'yii\web\JsonParser'],
    ],
    'component.request.backend' => [
        'cookieValidationKey' => getenv('BACKEND_COOKIE_VALIDATION_KEY'),
        'parsers' => ['application/json' => 'yii\web\JsonParser'],
    ],
    'component.formatter' => [
        'class' => components\i18n\Formatter::className(),
        'locale' => 'en',
        'timeZone' => 'Etc/GMT-0',
        'dateFormat' => 'dd MMMM y',
        'timeFormat' => 'HH:mm',
        'datetimeFormat' => 'dd MMMM y HH:mm',
    ],
    'component.authClientCollection' => [
        'class' => yii\authclient\Collection::className(),
        'clients' => include __DIR__ . '/_authclients.php',
    ],
];
