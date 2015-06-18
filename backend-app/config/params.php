<?php
/**
 * params.php
 * @author Revin Roman
 */

return [
    'component.user' => [
        'class' => 'yii\web\User',
        'identityClass' => 'resources\Account',
        'enableAutoLogin' => true,
        'loginUrl' => ['/account/sign/in'],
    ],
];
