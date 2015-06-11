<?php
/**
 * _menu.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 */

use rmrevin\yii\fontawesome\FA;

/** @var backend\components\Controller $Controller */
$Controller = $this->context;

return [
    [
        'label' => Yii::t('app', 'Link'),
        'url' => ['/'],
        'icon' => FA::icon('home'),
        'visible' => true,
        'selected' => true,
    ],
    [
        'label' => Yii::t('app', 'Link'),
        'url' => ['/'],
        'icon' => FA::icon('list'),
        'visible' => true,
        'selected' => false,
    ],
    [
        'label' => Yii::t('app', 'Dropdown'),
        'url' => ['/'],
        'icon' => FA::icon('user'),
        'visible' => true,
        'selected' => false,
        'items' => [
            [
                'label' => Yii::t('app', 'Action'),
                'url' => ['/'],
                'icon' => FA::icon('circle-o', ['class' => 'text-red']),
                'badge' => 'hot!',
                'visible' => true,
                'selected' => false,
            ],
            [
                'label' => Yii::t('app', 'Another action'),
                'url' => ['/'],
                'icon' => FA::icon('circle-o', ['class' => 'text-yellow']),
                'badge' => ['text' => 4, 'class' => 'bg-yellow'],
                'visible' => true,
                'selected' => false,
            ],
            [
                'label' => Yii::t('app', 'Something else here'),
                'url' => ['/'],
                'icon' => FA::icon('circle-o'),
                'visible' => true,
                'selected' => false,
            ],
            [
                'label' => Yii::t('app', 'Separated link'),
                'url' => ['/'],
                'icon' => FA::icon('circle-o'),
                'visible' => true,
                'selected' => false,
            ],
            [
                'label' => Yii::t('app', 'One more separated link'),
                'url' => ['/'],
                'icon' => FA::icon('circle-o'),
                'visible' => true,
                'selected' => false,
            ],
        ],
    ],
];