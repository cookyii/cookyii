<?php
/**
 * main.php
 * @author Revin Roman http://phptime.ru
 *
 * @var yii\web\View $this
 * @var string $content
 */
use rmrevin\yii\fontawesome\FA;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var \resources\User $User */
$User = User()->identity;

$this->beginContent('@app/views/layouts/_layout.php', ['content' => $content]);

?>
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav nav-side" id="side-menu">
                <li class="layout-change-btn"><span minimaliza-sidebar></span></li>
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <?
                        if (!User()->isGuest) {
                            ?>
                            <!-- Picture of user -->
                            <!--<img alt="image" class="img-circle" src="img/profile_small.jpg"/>-->
                            <?
                            echo Html::a($User->name, ['/account/my'], [
                                'class' => 'user',
                            ]);
                            echo Html::a(Yii::t('account', 'Выход'), ['/account/sign/out'], [
                                'class' => 'logout',
                            ]);
                        }
                        ?>
                    </div>
                    <div class="logo-element">
                        &nbsp;
                    </div>

                </li>

                <?
                function renderItem($item)
                {
                    $options = [];

                    if ($item['visible'] !== true) {
                        return null;
                    }

                    if (true === $item['selected']) {
                        Html::addCssClass($options, 'active');
                    }

                    if (!isset($item['items']) || empty($item['items'])) {
                        $label = '';
                        $subitems = '';

                        if (isset($item['icon'])) {
                            $label .= FA::icon($item['icon']) . ' ';
                        }
                        $label .= Html::tag('span', $item['label'], ['class' => 'nav-label']);
                        if (isset($item['counter'])) {
                            if (is_array($item['counter'])) {
                                $opt = ArrayHelper::remove($item['counter'], 'options', []);
                                $visible = ArrayHelper::remove($item['counter'], 'visible', true);
                                Html::addCssClass($opt, 'pull-right');

                                if ($visible === true) {
                                    $label .= ' ' . Html::tag('span', $item['counter']['value'], $opt);
                                }
                            } else {
                                $label .= ' ' . Html::tag('span', $item['counter'], ['class' => 'label label-defaul']);
                            }
                        }
                    } else {
                        $label = '';
                        $subitems = '';

                        if (isset($item['icon'])) {
                            $label .= FA::icon($item['icon']) . ' ';
                        }

                        $label .= Html::tag('span', $item['label'], ['class' => 'nav-label'])
                            . Html::tag('span', null, ['class' => 'fa arrow']);

                        foreach ($item['items'] as $subitem) {
                            $subitems .= renderItem($subitem);
                        }
                        $subitems = Html::tag('ul', $subitems, ['class' => 'nav nav-second-level']);
                    }

                    return Html::tag(
                        'li',
                        Html::a(
                            $label,
                            $item['url']
                        ) . $subitems,
                        $options
                    );
                }

                $menu_items = include(__DIR__ . '/_menu.php');
                foreach ($menu_items as $item) {
                    echo renderItem($item);
                }
                ?>
            </ul>
        </div>
    </nav>

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">

            <?= $content ?>

            <div class="footer">
                <div>
                    <strong><?= APP_NAME ?></strong> &copy; 2015
                </div>
            </div>
        </div>
    </div>
<?

$this->endContent();