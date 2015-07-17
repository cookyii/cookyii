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
        'sort' => 0,
    ],
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

usort($menu, function ($a, $b) {
    if (!isset($a['sort'])) {
        $a['sort'] = 9999999999;
    }

    if (!isset($b['sort'])) {
        $b['sort'] = 9999999999;
    }

    if ($a['sort'] === $b['sort']) {
        return 0;
    }

    return ($a['sort'] < $b['sort']) ? -1 : 1;
});

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