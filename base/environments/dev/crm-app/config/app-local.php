<?php

return [
    'bootstrap' => [
        'debug',
    ],
    'modules' => [
        'debug' => [
            'class' => yii\debug\Module::class,
            'allowedIPs' => ['*'],
        ],
    ],
];
