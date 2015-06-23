<?php
/**
 * _menu.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 *
 * @var yii\web\View $this
 */

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

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

/**
 * @param array|string $item
 * @return null|string
 */
function renderItem($item)
{
    $options = [];

    if (isset($item['visible']) && $item['visible'] !== true) {
        return null;
    }

    $anchor_options = [];

    if (!isset($item['items']) || empty($item['items'])) {
        $label = '';
        $subitems = '';

        if (isset($item['icon']) && !empty($item['icon'])) {
            $label .= $item['icon'] . ' ';
        }

        $label .= Html::tag('span', $item['label']);

        if (isset($item['badge'])) {
            if (!is_array($item['badge'])) {
                $item['badge'] = ['text' => $item['badge']];
            }

            $opt = ['class' => 'label pull-right'];

            if (isset($item['badge']['class'])) {
                Html::addCssClass($opt, $item['badge']['class']);
            }

            $label .= ' ' . Html::tag('small', $item['badge']['text'], $opt);
        }
    } else {
        $label = '';
        $subitems = '';

        if (isset($item['icon']) && !empty($item['icon'])) {
            $label .= $item['icon'] . ' ';
        }

        $label .= Html::tag('span', $item['label'])
            . FA::icon('angle-left')->pullRight();

        foreach ($item['items'] as $subitem) {
            $subitems .= renderItem($subitem);
        }

        $opt = ['class' => 'treeview-menu'];

        if (true === $item['selected']) {
            Html::addCssClass($opt, 'menu-open');
        }

        $subitems = Html::tag('ul', $subitems, $opt);

        Html::addCssClass($options, 'treeview');
    }

    if (true === $item['selected']) {
        Html::addCssClass($options, 'active');
    }

    return Html::tag(
        'li',
        Html::a(
            $label,
            $item['url'],
            $anchor_options
        ) . $subitems,
        $options
    );
}

return $menu;