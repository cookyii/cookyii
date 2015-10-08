<?php
/**
 * _authclients.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

$clients = [];

if (defined('FACEBOOK_CLIENT_ID') && FACEBOOK_CLIENT_ID !== null && FACEBOOK_CLIENT_ID !== false) {
    $clients[] = 'facebook';
}

if (defined('GITHUB_CLIENT_ID') && GITHUB_CLIENT_ID !== null && GITHUB_CLIENT_ID !== false) {
    $clients[] = 'github';
}

if (defined('GOOGLE_CLIENT_ID') && GOOGLE_CLIENT_ID !== null && GOOGLE_CLIENT_ID !== false) {
    $clients[] = 'google';
}

if (defined('LINKEDIN_CLIENT_ID') && LINKEDIN_CLIENT_ID !== null && LINKEDIN_CLIENT_ID !== false) {
    $clients[] = 'linkedin';
}

if (defined('LIVE_CLIENT_ID') && LIVE_CLIENT_ID !== null && LIVE_CLIENT_ID !== false) {
    $clients[] = 'live';
}

if (defined('TWITTER_CLIENT_ID') && TWITTER_CLIENT_ID !== null && TWITTER_CLIENT_ID !== false) {
    $clients[] = 'twitter';
}

if (defined('VKONTAKTE_CLIENT_ID') && VKONTAKTE_CLIENT_ID !== null && VKONTAKTE_CLIENT_ID !== false) {
    $clients[] = 'vkontakte';
}

if (defined('YANDEX_CLIENT_ID') && YANDEX_CLIENT_ID !== null && YANDEX_CLIENT_ID !== false) {
    $clients[] = 'yandex';
}

$authClients = [
    'facebook' => [
        'class' => yii\authclient\clients\Facebook::className(),
        'clientId' => 'FACEBOOK_CLIENT_ID',
        'clientSecret' => 'FACEBOOK_CLIENT_SECRET',
    ],
    'github' => [
        'class' => yii\authclient\clients\GitHub::className(),
        'clientId' => 'GITHUB_CLIENT_ID',
        'clientSecret' => 'GITHUB_CLIENT_SECRET',
    ],
    'google' => [
        'class' => yii\authclient\clients\GoogleOAuth::className(),
        'clientId' => 'GOOGLE_CLIENT_ID',
        'clientSecret' => 'GOOGLE_CLIENT_SECRET',
    ],
    'linkedin' => [
        'class' => yii\authclient\clients\LinkedIn::className(),
        'clientId' => 'LINKEDIN_CLIENT_ID',
        'clientSecret' => 'LINKEDIN_CLIENT_SECRET',
    ],
    'live' => [
        'class' => yii\authclient\clients\Live::className(),
        'clientId' => 'LIVE_CLIENT_ID',
        'clientSecret' => 'LIVE_CLIENT_SECRET',
    ],
    'twitter' => [
        'class' => yii\authclient\clients\Twitter::className(),
        'consumerKey' => 'TWITTER_CLIENT_ID',
        'consumerSecret' => 'TWITTER_CLIENT_SECRET',
    ],
    'vkontakte' => [
        'class' => yii\authclient\clients\VKontakte::className(),
        'clientId' => 'VKONTAKTE_CLIENT_ID',
        'clientSecret' => 'VKONTAKTE_CLIENT_SECRET',
    ],
    'yandex' => [
        'class' => yii\authclient\clients\YandexOAuth::className(),
        'clientId' => 'YANDEX_CLIENT_ID',
        'clientSecret' => 'YANDEX_CLIENT_SECRET',
    ],
];

$result = [];

foreach ($clients as $name) {
    $data = $authClients[$name];

    if (isset($data['clientId'])) {
        $data['clientId'] = constant($data['clientId']);
        $data['clientSecret'] = constant($data['clientSecret']);
    }

    if (isset($data['consumerKey'])) {
        $data['consumerKey'] = constant($data['consumerKey']);
        $data['consumerSecret'] = constant($data['consumerSecret']);
    }

    $result[$name] = $data;
}

return $result;