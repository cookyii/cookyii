<?php
/**
 * params.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

$ROLLBAR_ACCESS_TOKEN = getenv('ROLLBAR_ACCESS_TOKEN');

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
    'component.mailer' => [
        'class' => yii\swiftmailer\Mailer::className(),
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => getenv('SMTP_HOST'),
            'username' => getenv('SMTP_USER'),
            'password' => getenv('SMTP_PASS'),
            'port' => getenv('SMTP_PORT'),
            'encryption' => getenv('SMTP_ENC'),
        ],
    ],
    'component.rollbar' => [
        'class' => rmrevin\yii\rollbar\Component::className(),
        'accessToken' => $ROLLBAR_ACCESS_TOKEN,
        'enabled' => !empty($ROLLBAR_ACCESS_TOKEN) && $ROLLBAR_ACCESS_TOKEN !== 'null',
        'useLogger' => YII_DEBUG,
        'environment' => YII_ENV,
        'reportSuppressed' => true,
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
    'component.request.frontend' => [
        'cookieValidationKey' => getenv('FRONTEND_COOKIE_VALIDATION_KEY'),
        'parsers' => ['application/json' => 'yii\web\JsonParser'],
    ],
    'component.request.backend' => [
        'cookieValidationKey' => getenv('BACKEND_COOKIE_VALIDATION_KEY'),
        'parsers' => ['application/json' => 'yii\web\JsonParser'],
    ],
    'component.i18n' => [
        'class' => yii\i18n\I18N::className(),
        'translations' => [
            'cookyii' => yii\i18n\PhpMessageSource::className(),
        ],
    ],
    'component.formatter' => [
        'class' => components\i18n\Formatter::className(),
        'locale' => 'en',
        'timeZone' => 'Etc/GMT',
        'dateFormat' => 'dd MMMM y',
        'timeFormat' => 'HH:mm',
        'datetimeFormat' => 'dd MMMM y HH:mm',
    ],
    'component.authClientCollection' => [
        'class' => yii\authclient\Collection::className(),
        'clients' => include __DIR__ . '/_authclients.php',
    ],
];
