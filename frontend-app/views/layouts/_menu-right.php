<?php
/**
 * _menu-right.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

return [
    [
        'label' => Yii::t('app', 'Link'),
        'url' => ['/'],
        'icon' => null,
        'visible' => true,
        'selected' => false,
    ],
    [
        'label' => Yii::t('app', 'Dropdown'),
        'url' => ['/'],
        'icon' => null,
        'visible' => true,
        'selected' => false,
        'items' => [
            [
                'label' => Yii::t('app', 'Action'),
                'url' => ['/'],
                'icon' => null,
                'visible' => true,
                'selected' => false,
            ],
            [
                'label' => Yii::t('app', 'Another action'),
                'url' => ['/'],
                'icon' => null,
                'visible' => true,
                'selected' => false,
            ],
            [
                'label' => Yii::t('app', 'Something else here'),
                'url' => ['/'],
                'icon' => null,
                'visible' => true,
                'selected' => false,
            ],
            '|',
            [
                'label' => Yii::t('app', 'Separated link'),
                'url' => ['/'],
                'icon' => null,
                'visible' => true,
                'selected' => false,
            ],
        ],
    ],
];