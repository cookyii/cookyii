<?php
/**
 * params.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

return [
    'component.user' => [
        'class' => 'yii\web\User',
        'identityClass' => 'resources\Account',
        'enableAutoLogin' => true,
        'loginUrl' => ['/'],
    ],
];
