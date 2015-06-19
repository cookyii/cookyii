<?php
/**
 * index.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 */

use cookyii\modules\Page;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Json;

$this->title = Yii::t('page', 'Pages management');

Page\backend\_assets\ListAssetBundle::register($this);

/**
 * @param string $type
 * @param string $label
 * @return string
 */
function sortLink($type, $label)
{
    $label .= ' ' . FA::icon('sort-numeric-desc', ['ng-show' => 'sort === "-' . $type . '"']);
    $label .= ' ' . FA::icon('sort-numeric-asc', ['ng-show' => 'sort === "' . $type . '"']);

    return Html::a($label, null, [
        'ng-click' => 'setSort("' . $type . '")',
    ]);
}

?>

<section <?= Html::renderTagAttributes([
    'class' => 'content',
    'ng-controller' => 'PageListController',
]) ?>>
    <div class="row">
        <div class="col-xs-3 com-sm-3 col-md-3 col-lg-2">
            <div class="box-filter">
                <h3><?= Yii::t('page', 'Filter') ?></h3>

                <hr>

                <?= Html::tag('a', FA::icon('check') . ' ' . Yii::t('page', 'Removed pages'), [
                    'ng-click' => 'toggleDeleted()',
                    'ng-class' => Json::encode(['selected' => new \yii\web\JsExpression('deleted === true')]),
                ]) ?>
            </div>
        </div>
        <div class="col-xs-9 com-sm-9 col-md-9 col-lg-10">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= Yii::t('page', 'Pages list') ?></h3>

                    <div class="box-tools">
                        <?= Html::tag('pagination', null, [
                            'class' => 'pagination pagination-sm no-margin pull-right',
                            'ng-model' => 'pagination.currentPage',
                            'total-items' => 'pagination.totalCount',
                            'items-per-page' => 'pagination.perPage',
                            'ng-change' => 'doPageChanged()',
                            'max-size' => '10',
                            'previous-text' => '‹',
                            'next-text' => '›',
                        ]) ?>

                        <form ng-submit="doSearch()" class="pull-right">
                            <div class="input-group search" ng-class="{'wide':search.length>0||searchFocus}">
                                <?= Html::textInput(null, null, [
                                    'class' => 'form-control input-sm pull-right',
                                    'placeholder' => Yii::t('page', 'Search'),
                                    'maxlength' => 100,
                                    'ng-model' => 'search',
                                    'ng-focus' => 'toggleSearchFocus()',
                                    'ng-blur' => 'doSearch()',
                                ]) ?>
                                <a ng-click="clearSearch()" ng-show="search" class="clear-search">
                                    <?= FA::icon('times') ?>
                                </a>

                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-default" ng-click="doSearch()">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="box-body no-padding">
                    <table class="table table-hover table-pages">
                        <thead>
                        <tr>
                            <td class="activated">&nbsp;</td>
                            <td class="id"><?= sortLink('id', Yii::t('page', 'ID')) ?></td>
                            <td class="name"><?= sortLink('title', Yii::t('page', 'Title')) ?></td>
                            <td class="updated"><?= sortLink('updated_at', Yii::t('page', 'Updated at')) ?></td>
                            <td class="actions">&nbsp;</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $options = [
                            'title' => Yii::t('page', 'Edit page'),
                            'ng-class' => '{deactivated:page.activated===0,deleted:page.deleted}',
                        ];
                        ?>
                        <tr ng-show="pages.length === 0">
                            <td colspan="6" class="text-center text-italic text-light">
                                <?= Yii::t('page', 'Pages not found') ?>
                            </td>
                        </tr>
                        <tr ng-repeat="page in pages track by page.id" <?= Html::renderTagAttributes($options) ?>>
                            <td class="activated clickable">
                                <md-switch ng-model="page.activated"
                                           ng-true-value="1" ng-false-value="0"
                                           ng-change="toggleActivated(page)"
                                           title="Page {{ page.activated === 1 ? 'activated' : 'deactivated' }}"
                                           aria-label="Page {{ page.activated === 1 ? 'activated' : 'deactivated' }}">
                                </md-switch>
                            </td>
                            <td class="id clickable" ng-click="edit(page)">{{ page.id }}</td>
                            <td class="title clickable" ng-click="edit(page)">{{ page.title }}</td>
                            <td class="updated clickable" ng-click="edit(page)">
                                {{ page.updated_at * 1000 | date:'dd MMM yyyy HH:mm' }}
                            </td>
                            <td class="actions">
                                <?php
                                echo Html::tag('a', FA::icon('times'), [
                                    'class' => 'text-red',
                                    'title' => Yii::t('page', 'Remove page'),
                                    'ng-click' => 'remove(page, $event)',
                                    'ng-show' => '!page.deleted',
                                ]);
                                echo Html::tag('a', FA::icon('undo'), [
                                    'class' => 'text-light-blue',
                                    'title' => Yii::t('page', 'Restore page'),
                                    'ng-click' => 'restore(page)',
                                    'ng-show' => 'page.deleted',
                                ]);
                                ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="box-footer clearfix">
                    <?= Html::tag('pagination', null, [
                        'class' => 'pagination pagination-sm no-margin pull-right',
                        'ng-model' => 'pagination.currentPage',
                        'total-items' => 'pagination.totalCount',
                        'items-per-page' => 'pagination.perPage',
                        'ng-change' => 'doPageChanged()',
                        'max-size' => '10',
                        'previous-text' => '‹',
                        'next-text' => '›',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    echo Html::tag('md-button', FA::icon('plus')->fixedWidth(), [
        'class' => 'md-warn md-fab md-fab-bottom-right',
        'title' => Yii::t('page', 'Create new page'),
        'ng-click' => 'addPage()',
        'aria-label' => 'Add page',
    ]);
    ?>
</section>