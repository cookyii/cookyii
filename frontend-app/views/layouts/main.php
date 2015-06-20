<?php
/**
 * main.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 *
 * @var yii\web\View $this
 * @var string $content
 */

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var \resources\User $User */
$User = User()->identity;

$this->beginContent('@app/views/layouts/_layout.php', ['content' => $content]);

?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Brand</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
                    $menu_items = include(__DIR__ . '/_menu-left.php');
                    foreach ($menu_items as $item) {
                        echo renderItem($item);
                    }
                    ?>
                </ul>
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    $menu_items = include(__DIR__ . '/_menu-right.php');
                    foreach ($menu_items as $item) {
                        echo renderItem($item);
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="container">
        <?= $content ?>
    </div>

    <div class="footer text-center">
        <div>
            <strong><?= APP_NAME ?></strong> &copy; 2015
        </div>
    </div>
<?php

$this->endContent();

/**
 * @param array|string $item
 * @return null|string
 */
function renderItem($item)
{
    $options = [];

    if ('|' === $item) {
        return Html::tag('li', null, ['class' => 'divider']);
    }

    if ($item['visible'] !== true) {
        return null;
    }

    if (true === $item['selected']) {
        Html::addCssClass($options, 'active');
    }

    $anchor_options = [];

    if (!isset($item['items']) || empty($item['items'])) {
        $label = '';
        $subitems = '';

        if (isset($item['icon'])) {
            $label .= FA::icon($item['icon']) . ' ';
        }

        $label .= $item['label'];
    } else {
        $label = '';
        $subitems = '';

        if (isset($item['icon'])) {
            $label .= FA::icon($item['icon']) . ' ';
        }

        $label .= $item['label']
            . Html::tag('span', null, ['class' => 'caret']);

        foreach ($item['items'] as $subitem) {
            $subitems .= renderItem($subitem);
        }

        $subitems = Html::tag('ul', $subitems, ['class' => 'dropdown-menu', 'role' => 'menu']);

        Html::addCssClass($options, 'dropdown');
        Html::addCssClass($anchor_options, 'dropdown-toggle');

        $anchor_options['data-toggle'] = 'dropdown';
        $anchor_options['role'] = 'button';
        $anchor_options['aria-expanded'] = 'false';
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