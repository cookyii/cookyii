<?php
/**
 * params.php
 * @author Revin Roman
 */

return [
    'component.user' => [
        'class' => 'yii\web\User',
        'identityClass' => 'resources\User',
        'enableAutoLogin' => true,
        'loginUrl' => ['/'],
    ],
];
