<?php
/**
 * params.php
 * @author Revin Roman
 */

return [
    'component.db' => [
        'class' => 'yii\db\Connection',
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
        'class' => 'yii\web\DbSession',
    ],
    'component.security' => [
        'class' => 'yii\base\Security',
    ],
    'component.log' => [
        'class' => 'yii\log\Dispatcher',
        'targets' => [],
    ],
    'component.view' => [
        'class' => 'yii\web\View',
    ],
    'component.user' => [
        'class' => 'yii\web\User',
        'enableAutoLogin' => true,
        'loginUrl' => ['/'],
    ],
    'component.authManager' => [
        'class' => 'yii\rbac\DbManager',
        'itemTable' => '{{%rbac_item}}',
        'itemChildTable' => '{{%rbac_item_child}}',
        'assignmentTable' => '{{%rbac_assignment}}',
        'ruleTable' => '{{%rbac_rule}}',
        'cache' => 'cache.authManager',
    ],
    'component.cache' => [
        'class' => 'yii\caching\DbCache',
        'keyPrefix' => 'normal-',
    ],
    'component.cache.authManager' => [
        'class' => 'yii\caching\ApcCache', // apc cache not available in cli!
        'keyPrefix' => 'authManager-',
    ],
    'component.cache.schema' => [
        'class' => 'yii\caching\ApcCache', // apc cache not available in cli!
        'keyPrefix' => 'schema-',
    ],
    'component.cache.query' => [
        'class' => 'yii\caching\ApcCache', // apc cache not available in cli!
        'keyPrefix' => 'query-',
    ],
    'component.assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
        'linkAssets' => true,
        'bundles' => [
            'yii\bootstrap\BootstrapAsset' => ['css' => []],
        ],
    ],
    'component.urlManager.frontend' => [
        'class' => 'yii\web\UrlManager',
        'baseUrl' => '/',
        'hostInfo' => sprintf('http://%s', getenv('FRONTEND_DOMAIN')),
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'ruleConfig' => [
            'class' => 'yii\web\UrlRule',
            'encodeParams' => false,
        ],
        'rules' => require(\Yii::getAlias('@frontend/config/urls.php')),
    ],
    'component.urlManager.backend' => [
        'class' => 'yii\web\UrlManager',
        'baseUrl' => '/',
        'hostInfo' => sprintf('http://%s', getenv('BACKEND_DOMAIN')),
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'ruleConfig' => [
            'class' => 'yii\web\UrlRule',
            'encodeParams' => false,
        ],
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
        'class' => 'common\components\Formatter',
        'locale' => 'en',
        'timeZone' => 'Etc/GMT-0',
        'dateFormat' => 'dd MMMM y',
        'timeFormat' => 'HH:mm',
        'datetimeFormat' => 'dd MMMM y HH:mm',
    ],
    'component.postman' => [
        'class' => 'rmrevin\yii\postman\Component',
        'driver' => 'smtp',
        'default_from' => [getenv('SMTP_USER'), 'cookyii'],
        'subject_prefix' => 'cookyii / ',
        'smtp_config' => [
            'host' => getenv('SMTP_HOST'),
            'port' => getenv('SMTP_PORT'),
            'auth' => true,
            'user' => getenv('SMTP_USER'),
            'password' => getenv('SMTP_PASSWORD'),
            'secure' => getenv('SMTP_ENCRYPT') === 'true' ? 'ssl' : '',
            'debug' => false,
        ],
    ],
];
