<?php
/**
 * params.php
 * @author Revin Roman http://phptime.ru
 */

use yii\helpers\ArrayHelper;

$defaultDbConfig = [
    'class' => yii\db\Connection::class,
    'charset' => 'utf8',
    'enableSchemaCache' => true,
    'schemaCache' => 'cache.schema',
];

return [
    'component.db.production' => ArrayHelper::merge(
        $defaultDbConfig,
        [
            'dsn' => DB_DSN,
            'username' => DB_USER,
            'password' => DB_PASS,
            'tablePrefix' => 'yii_'
        ]
    ),
    'component.db.test' => ArrayHelper::merge(
        $defaultDbConfig,
        [
            'dsn' => DB_TEST_DSN,
            'username' => DB_TEST_USER,
            'password' => DB_TEST_PASS,
            'tablePrefix' => 'yii_'
        ]
    ),
    'component.session' => [
        'class' => yii\web\CacheSession::class,
        'cache' => 'cache.session',
    ],
    'component.security' => [
        'class' => yii\base\Security::class,
        'passwordHashStrategy' => 'password_hash',
    ],
    'component.log' => [
        'class' => yii\log\Dispatcher::class,
        'targets' => [],
    ],
    'component.view' => [
        'class' => yii\web\View::class,
    ],
    'component.user' => [
        'class' => yii\web\User::class,
        'enableAutoLogin' => true,
        'loginUrl' => ['/'],
    ],
    'component.authManager' => [
        'class' => yii\rbac\DbManager::class,
        'itemTable' => '{{%rbac_item}}',
        'itemChildTable' => '{{%rbac_item_child}}',
        'assignmentTable' => '{{%rbac_assignment}}',
        'ruleTable' => '{{%rbac_rule}}',
        'cache' => 'cache.authManager',
    ],
    'component.cache' => [
        'class' => yii\caching\DbCache::class,
        'keyPrefix' => 'normal-',
    ],
    'component.cache.session' => [
        'class' => yii\caching\ApcCache::class, // apc cache not available in cli!
        'keyPrefix' => 'session-',
    ],
    'component.cache.authManager' => [
        'class' => yii\caching\ApcCache::class, // apc cache not available in cli!
        'keyPrefix' => 'authManager-',
    ],
    'component.cache.schema' => [
        'class' => yii\caching\ApcCache::class, // apc cache not available in cli!
        'keyPrefix' => 'schema-',
    ],
    'component.cache.query' => [
        'class' => yii\caching\ApcCache::class, // apc cache not available in cli!
        'keyPrefix' => 'query-',
    ],
    'component.assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
        'linkAssets' => true,
        'bundles' => [
            yii\bootstrap\BootstrapAsset::class => [
                'css' => [],
            ],
        ],
    ],
    'component.urlManager.frontend' => [
        'class' => yii\web\UrlManager::class,
        'baseUrl' => '/',
        'hostInfo' => (USE_SSL ? 'https' : 'http') . '://' . DOMAIN_FRONTEND,
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'ruleConfig' => [
            'class' => yii\web\UrlRule::class,
            'encodeParams' => false,
        ],
//        'rules' => require(\Yii::getAlias('@frontend/config/urls.php')),
    ],
    'component.urlManager.backend' => [
        'class' => yii\web\UrlManager::class,
        'baseUrl' => '/',
        'hostInfo' => (USE_SSL ? 'https' : 'http') . '://' . DOMAIN_BACKEND,
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'ruleConfig' => [
            'class' => yii\web\UrlRule::class,
            'encodeParams' => false,
        ],
//        'rules' => require(\Yii::getAlias('@backend/config/urls.php')),
    ],
    'component.urlManager.crm' => [
        'class' => yii\web\UrlManager::class,
        'baseUrl' => '/',
        'hostInfo' => (USE_SSL ? 'https' : 'http') . '://' . DOMAIN_CRM,
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'ruleConfig' => [
            'class' => yii\web\UrlRule::class,
            'encodeParams' => false,
        ],
        'rules' => require(\Yii::getAlias('@crm/config/urls.php')),
    ],
    'component.errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'component.i18n' => [
    ],
    'component.request' => [
        'cookieValidationKey' => sha1(APP_NAME . '.cookie.key.sd45hadf63ljkjd554ang4576sj'),
        'parsers' => [
            'application/json' => yii\web\JsonParser::class,
        ],
    ],
    'component.formatter' => [
        'class' => common\components\Formatter::class,
        'locale' => 'en',
        'timeZone' => 'Etc/GMT-0',
        'dateFormat' => 'dd MMMM y',
        'timeFormat' => 'HH:mm',
        'datetimeFormat' => 'dd MMMM y HH:mm',
    ],
    'component.postman' => [
        'class' => rmrevin\yii\postman\Component::class,
        'driver' => 'smtp',
        'default_from' => [SMTP_USER, 'cookyii'],
        'subject_prefix' => 'cookyii / ',
        'smtp_config' => [
            'host' => SMTP_HOST,
            'port' => SMTP_PORT,
            'auth' => true,
            'user' => SMTP_USER,
            'password' => SMTP_PASSWORD,
            'secure' => SMTP_ENCRYPT === true ? 'ssl' : '',
            'debug' => false,
        ],
    ],
];
