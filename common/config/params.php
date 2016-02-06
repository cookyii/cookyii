<?php
/**
 * params.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

$frontend = parse_url(FRONTEND_URL);
$backend = parse_url(BACKEND_URL);
$crm = parse_url(CRM_URL);

if (empty($frontend)) {
    throw new \yii\base\InvalidConfigException('You must specify the url for the frontend application (FRONTEND_URL).');
}

if (empty($backend)) {
    throw new \yii\base\InvalidConfigException('You must specify the url for the backend application (BACKEND_URL).');
}

if (empty($crm)) {
    throw new \yii\base\InvalidConfigException('You must specify the url for the crm application (CRM_URL).');
}

$cookieDomain = str_replace('backend', '', parse_url(BACKEND_URL, PHP_URL_HOST));

return [
    'module.media' => [
        'class' => cookyii\modules\Media\Module::className(),
    ],
    'module.postman' => [
        'class' => cookyii\modules\Postman\Module::className(),
        'subjectPrefix' => 'Cookyii //',
    ],

    'component.db' => [
        'class' => yii\db\Connection::className(),
        'charset' => 'utf8',
        'enableSchemaCache' => true,
        'schemaCache' => 'cache.schema',
        'enableQueryCache' => false,
        'queryCache' => 'cache.query',
        'dsn' => DB_DSN,
        'username' => DB_USER,
        'password' => DB_PASS,
        'tablePrefix' => 'yii_',
    ],
    'component.mailer' => [
        'class' => yii\swiftmailer\Mailer::className(),
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => SMTP_HOST,
            'username' => SMTP_USER,
            'password' => SMTP_PASS,
            'port' => SMTP_PORT,
            'encryption' => SMTP_ENC,
        ],
    ],
    'component.session' => [
        'class' => yii\web\DbSession::className(),
        'cookieParams' => [
            'httpOnly' => true,
            'domain' => $cookieDomain,
        ],
    ],
    'component.security' => [
        'class' => yii\base\Security::className(),
    ],
    'component.log' => [
        'class' => yii\log\Dispatcher::className(),
        'targets' => [],
    ],
    'component.view' => [
        'class' => rmrevin\yii\minify\View::className(),
        'enableMinify' => !YII_DEBUG,
        'compress_output' => !YII_DEBUG,
    ],
    'component.user' => [
        'class' => yii\web\User::className(),
        'enableAutoLogin' => true,
        'loginUrl' => ['/account/sign/in'],
        'identityClass' => resources\Account::className(),
        'identityCookie' => [
            'name' => '_identity',
            'httpOnly' => true,
            'domain' => $cookieDomain,
        ],
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
    ],
    'component.urlManager.frontend' => [
        'class' => yii\web\UrlManager::className(),
        'baseUrl' => isset($frontend['path']) ? $frontend['path'] : '/',
        'hostInfo' => sprintf('%s://%s', $frontend['scheme'], $frontend['host']),
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'cache' => false,
        'rules' => require(\Yii::getAlias('@frontend/config/urls.php')),
    ],
    'component.urlManager.backend' => [
        'class' => yii\web\UrlManager::className(),
        'baseUrl' => isset($backend['path']) ? $backend['path'] : '/',
        'hostInfo' => sprintf('%s://%s', $backend['scheme'], $backend['host']),
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'cache' => false,
        'rules' => require(\Yii::getAlias('@backend/config/urls.php')),
    ],
    'component.urlManager.crm' => [
        'class' => yii\web\UrlManager::className(),
        'baseUrl' => isset($crm['path']) ? $crm['path'] : '/',
        'hostInfo' => sprintf('%s://%s', $crm['scheme'], $crm['host']),
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'cache' => false,
        'rules' => require(\Yii::getAlias('@crm/config/urls.php')),
    ],
    'component.request' => [
        'cookieValidationKey' => COOKIE_VALIDATION_KEY,
        'parsers' => ['application/json' => 'yii\web\JsonParser'],
    ],
    'component.i18n' => [
        'class' => yii\i18n\I18N::className(),
        'translations' => [
            'app*' => [
                'class' => yii\i18n\PhpMessageSource::className(),
                'basePath' => '@messages',
            ],
            'cookyii*' => [
                'class' => yii\i18n\PhpMessageSource::className(),
                'basePath' => '@cookyii/messages',
            ],
        ],
    ],
    'component.formatter' => [
        'class' => cookyii\i18n\Formatter::className(),
        'timeZone' => 'Etc/GMT',
        'dateFormat' => 'dd MMMM y',
        'timeFormat' => 'HH:mm',
        'datetimeFormat' => 'dd.MM.y HH:mm',
    ],
];
