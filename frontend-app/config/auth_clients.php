<?php
/**
 * auth_clients.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

$providers = [
    'facebook' => [
        'class' => \yii\authclient\clients\Facebook::className(),
        'clientId' => __constant('FACEBOOK_CLIENT_ID'),
        'clientSecret' => __constant('FACEBOOK_CLIENT_SECRET'),
    ],
    'github' => [
        'class' => \yii\authclient\clients\GitHub::className(),
        'clientId' => __constant('GITHUB_CLIENT_ID'),
        'clientSecret' => __constant('GITHUB_CLIENT_SECRET'),
    ],
    'google' => [
        'class' => \yii\authclient\clients\GoogleOAuth::className(),
        'clientId' => __constant('GOOGLE_CLIENT_ID'),
        'clientSecret' => __constant('GOOGLE_CLIENT_SECRET'),
    ],
    'linkedin' => [
        'class' => \yii\authclient\clients\LinkedIn::className(),
        'clientId' => __constant('LINKEDIN_CLIENT_ID'),
        'clientSecret' => __constant('LINKEDIN_CLIENT_SECRET'),
    ],
    'live' => [
        'class' => \yii\authclient\clients\Live::className(),
        'clientId' => __constant('LIVE_CLIENT_ID'),
        'clientSecret' => __constant('LIVE_CLIENT_SECRET'),
    ],
    'twitter' => [
        'class' => \yii\authclient\clients\Twitter::className(),
        'consumerKey' => __constant('TWITTER_CLIENT_ID'),
        'consumerSecret' => __constant('TWITTER_CLIENT_SECRET'),
    ],
    'vkontakte' => [
        'class' => \yii\authclient\clients\VKontakte::className(),
        'clientId' => __constant('VKONTAKTE_CLIENT_ID'),
        'clientSecret' => __constant('VKONTAKTE_CLIENT_SECRET'),
    ],
    'yandex' => [
        'class' => \yii\authclient\clients\YandexOAuth::className(),
        'clientId' => __constant('YANDEX_CLIENT_ID'),
        'clientSecret' => __constant('YANDEX_CLIENT_SECRET'),
    ],
];

/**
 * @param string $name
 * @return mixed|null
 */
function __constant($name)
{
    return defined($name) ? constant($name) : null;
}

$result = [];
foreach ($providers as $provider => $conf) {
    $client_id = array_key_exists('consumerKey', $conf) ? $conf['consumerKey'] : $conf['clientId'];
    if (!empty($client_id)) {
        $result[$provider] = $conf;
    }
}

return $result;