<?php
/**
 * params.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

return [
    'component.user' => [
        'class' => 'yii\web\User',
        'identityClass' => 'cookyii\modules\Account\resources\Account',
        'enableAutoLogin' => true,
        'loginUrl' => ['/'],
    ],
];
