<?php
/**
 * _authclients.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

$authClients = [
    'facebook' => [
        'class' => 'yii\authclient\clients\Facebook',
        'app_id' => 'FACEBOOK_CLIENT_ID',
        'app_secret' => 'FACEBOOK_CLIENT_SECRET',
    ],
    'github' => [
        'class' => 'yii\authclient\clients\GitHub',
        'app_id' => 'GITHUB_CLIENT_ID',
        'app_secret' => 'GITHUB_CLIENT_SECRET',
    ],
    'google' => [
        'class' => 'yii\authclient\clients\GoogleOAuth',
        'app_id' => 'GOOGLE_CLIENT_ID',
        'app_secret' => 'GOOGLE_CLIENT_SECRET',
    ],
    'linkedin' => [
        'class' => 'yii\authclient\clients\LinkedIn',
        'app_id' => 'LINKEDIN_CLIENT_ID',
        'app_secret' => 'LINKEDIN_CLIENT_SECRET',
    ],
    'live' => [
        'class' => 'yii\authclient\clients\Live',
        'app_id' => 'LIVE_CLIENT_ID',
        'app_secret' => 'LIVE_CLIENT_SECRET',
    ],
    'twitter' => [
        'class' => 'yii\authclient\clients\Twitter',
        'app_id' => 'TWITTER_CLIENT_ID',
        'app_secret' => 'TWITTER_CLIENT_SECRET',
    ],
    'vkontakte' => [
        'class' => 'yii\authclient\clients\VKontakte',
        'app_id' => 'VKONTAKTE_CLIENT_ID',
        'app_secret' => 'VKONTAKTE_CLIENT_SECRET',
    ],
    'yandex' => [
        'class' => 'yii\authclient\clients\YandexOAuth',
        'app_id' => 'YANDEX_CLIENT_ID',
        'app_secret' => 'YANDEX_CLIENT_SECRET',
    ],
];

$result = [];

foreach ($authClients as $name => $conf) {
    if (isset($_ENV[$conf['app_id']]) && !empty($_ENV[$conf['app_id']]) && !in_array($_ENV[$conf['app_id']], ['null', 'false'], true)) {
        $result[$name] = [
            'class' => $conf['class'],
            'clientId' => constant($conf['app_id']),
            'clientSecret' => constant($conf['app_secret']),
        ];
    }
}

return $result;