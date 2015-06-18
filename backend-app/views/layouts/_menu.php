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

$menu = [
    [
        'label' => Yii::t('app', 'Dashboard'),
        'url' => ['/dash/index'],
        'icon' => FA::icon('home'),
        'visible' => true,
        'selected' => $Controller->id === 'dash',
    ],
    /*[
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
    ],*/
];

foreach (\Yii::$app->modules as $module => $conf) {
    $Module = null;

    if (is_string($conf)) {
        $Module = new $conf($module);
    }

    if (is_object($conf)) {
        $Module = $conf;
    }

    if ($Module instanceof \backend\interfaces\BackendModuleInterface) {
        $menu = array_merge($menu, $Module->menu($this->context));
    }
}

return $menu;