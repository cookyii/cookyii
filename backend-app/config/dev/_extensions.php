<?php
/**
 * _extensions.php
 * @author Revin Roman http://phptime.ru
 */

return [
    'cookyii/module-account' => [
        'name' => 'cookyii/module-account',
        'version' => '0.0.0.0',
        'alias' => ['@cookyii/module-account' => \Yii::getAlias('@modules/Account')],
    ],
    'cookyii/module-media' => [
        'name' => 'cookyii/module-media',
        'version' => '0.0.0.0',
        'alias' => ['@cookyii/module-media' => \Yii::getAlias('@modules/Media')],
    ],
    'cookyii/module-page' => [
        'name' => 'cookyii/module-page',
        'version' => '0.0.0.0',
        'alias' => ['@cookyii/module-page' => \Yii::getAlias('@modules/Page')],
    ],
];