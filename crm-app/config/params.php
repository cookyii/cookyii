<?php
/**
 * params.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

return [
    'component.authClientCollection' => [
        'class' => yii\authclient\Collection::className(),
        'clients' => require __DIR__ . '/auth_clients.php',
    ],
];
