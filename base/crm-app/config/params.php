<?php
/**
 * params.php
 * @author Revin Roman http://phptime.ru
 */

return [
    'component.user' => [
        'class' => yii\web\User::class,
        'identityClass' => crm\components\SimpleUser::class,
        'enableAutoLogin' => true,
        'loginUrl' => ['/'],
    ],
];
