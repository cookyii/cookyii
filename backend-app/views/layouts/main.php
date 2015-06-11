<?php
/**
 * main.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 * @var string $content
 */
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var \resources\User $User */
$User = User()->identity;

$this->beginContent('@app/views/layouts/_layout.php', ['content' => $content]);

$letters = array_map(function ($val) { return mb_substr($val, 0, 1, 'utf-8'); }, explode(' ', APP_NAME));

/** @var \resources\User $User */
$User = User()->identity;

?>
    <header class="main-header">
        <!-- Logo -->
        <a href="../../index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><?= implode('', $letters) ?></span>
            <span class="logo-lg"><?= APP_NAME ?></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?= Html::img($User->present->getAvatar(25), ['alt' => 'User Image', 'class' => 'user-image']) ?>
                            <span class="hidden-xs"><?= $User->name ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <?= Html::img($User->present->getAvatar(90), ['alt' => 'User Image', 'class' => 'img-circle']) ?>

                                <p><?= $User->name ?></p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <?= Html::a(\Yii::t('app', 'Profile'), ['/account'], ['class' => 'btn btn-default btn-flat']) ?>
                                </div>
                                <div class="pull-right">
                                    <?= Html::a(\Yii::t('app', 'Sign out'), ['/account/sign/out'], ['class' => 'btn btn-default btn-flat']) ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <?= Html::img($User->present->getAvatar(45), ['alt' => 'User Image', 'class' => 'img-circle']) ?>
                </div>
                <div class="pull-left info">
                    <p><?= $User->name ?></p>

                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>
                <?
                $menu_items = include(__DIR__ . '/_menu.php');
                foreach ($menu_items as $item) {
                    echo renderItem($item);
                }
                ?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
        <?= $content ?>
    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; 2015 <?= APP_NAME ?>.</strong> All rights reserved.
    </footer>

<?

$this->endContent();

/**
 * @param array|string $item
 * @return null|string
 */
function renderItem($item)
{
    $options = [];

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

        $label .= $item['label']
            . FA::icon('angle-left')->pullRight();

        foreach ($item['items'] as $subitem) {
            $subitems .= renderItem($subitem);
        }

        $subitems = Html::tag('ul', $subitems, ['class' => 'treeview-menu']);

        Html::addCssClass($options, 'treeview');
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