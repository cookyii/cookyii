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
    'schemaCache' => new yii\caching\ApcCache(['keyPrefix' => 'foodbook-schema-']),
];

return [
    'component.db.production' => ArrayHelper::merge(
        $defaultDbConfig,
        [
            'dsn' => MYSQL_DSN,
            'username' => MYSQL_USER,
            'password' => MYSQL_PASS,
            'tablePrefix' => 'yii_'
        ]
    ),
    'component.db.test' => ArrayHelper::merge(
        $defaultDbConfig,
        [
            'dsn' => MYSQL_TEST_DSN,
            'username' => MYSQL_TEST_USER,
            'password' => MYSQL_TEST_PASS,
            'tablePrefix' => 'yii_'
        ]
    ),
    'component.session' => [
        'class' => yii\web\CacheSession::class,
        'cache' => [
            'class' => yii\caching\ApcCache::class,
            'keyPrefix' => 'foodbook-session-',
        ],
    ],
    'component.security' => [
        'class' => yii\base\Security::class,
        'passwordHashStrategy' => 'password_hash',
    ],
    'component.errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'component.log' => [
        'class' => yii\log\Dispatcher::class,
        'targets' => [],
    ],
    'component.user' => [
        'class' => yii\web\User::class,
        'enableAutoLogin' => true,
        'loginUrl' => ['/'],
    ],
    'component.postman' => [
        'class' => rmrevin\yii\postman\Component::class,
        'driver' => 'smtp',
        'default_from' => [SMTP_USER, 'foodbook.cake'],
        'subject_prefix' => 'foodbook.cake / ',
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
    'component.authManager' => [
        'class' => yii\rbac\DbManager::class,
        'itemTable' => '{{%rbac_item}}',
        'itemChildTable' => '{{%rbac_item_child}}',
        'assignmentTable' => '{{%rbac_assignment}}',
        'ruleTable' => '{{%rbac_rule}}',
        'cache' => [
            'class' => yii\caching\ApcCache::class,
            'keyPrefix' => 'foodbook-rbac-',
        ],
    ],
    'component.cache' => [
        'class' => yii\caching\DbCache::class, // apc cache not available in cli!
        'keyPrefix' => 'foodbook-',
    ],
    'component.assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
        'linkAssets' => true,
        'bundles' => [
            yii\bootstrap\BootstrapAsset::class => [
                'css' => [],
            ],
            yii\authclient\widgets\AuthChoiceStyleAsset::class => [
                'css' => [],
            ],
        ],
    ],
    'component.urlManager.cake' => [
        'class' => yii\web\UrlManager::class,
        'baseUrl' => '/',
        'hostInfo' => (USE_SSL ? 'https' : 'http') . '://' . DOMAIN_CAKE,
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'ruleConfig' => [
            'class' => yii\web\UrlRule::class,
            'encodeParams' => false,
        ],
        'rules' => require(\Yii::getAlias('@cake/config/urls.php')),
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
    'component.view' => [
        'class' => yii\web\View::class,
    ],
    'component.i18n' => [
    ],
    'component.request' => [
        'cookieValidationKey' => sha1(APP_NAME . '.cookie.key.35d42g46sdh46f34h'),
        'parsers' => [
            'application/json' => yii\web\JsonParser::class,
        ],
    ],
    'component.formatter' => [
        'class' => common\components\Formatter::class,
        'locale' => 'ru',
        'timeZone' => 'Etc/GMT-3',
        'dateFormat' => 'dd MMMM y',
        'timeFormat' => 'HH:mm',
        'datetimeFormat' => 'dd MMMM y HH:mm',
    ],
    'component.authClientCollection' => [
        'class' => yii\authclient\Collection::class,
        'clients' => [
            'facebook' => [
                'class' => yii\authclient\clients\Facebook::class,
                'clientId' => FACEBOOK_CLIENT_ID,
                'clientSecret' => FACEBOOK_CLIENT_SECRET,
            ],
        ],
    ],
    'component.xxtea' => [
        'class' => rmrevin\yii\xxtea\Component::class,
        'key' => 'G4kfKqoRj37Clmw4', // 16 letters
        'base64_encode' => true,
    ],
];
