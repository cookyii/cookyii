<?php
/**
 * params.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

return [
    'component.authClientCollection' => [
        'class' => yii\authclient\Collection::className(),
        'clients' => [
            'github' => [
                'class' => yii\authclient\clients\GitHub::class,
                'clientId' => GITHUB_CLIENT_ID,
                'clientSecret' => GITHUB_CLIENT_SECRET,
                'scope' => 'user:email',
            ],
        ],
    ],
];
