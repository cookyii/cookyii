<?php
/**
 * index.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 */

use components\helpers\Material;
use cookyii\modules\Feed;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Json;

$this->title = Yii::t('feed', 'Sections management');

Feed\backend\assets\ListAssetBundle::register($this);

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
    'ng-controller' => 'ListController',
]) ?>>
    <div class="row">
        <div class="col-xs-3 com-sm-3 col-md-3 col-lg-2">
            <div class="box-filter">
                <h3><?= Yii::t('feed', 'Filter') ?></h3>

                <hr>

                <?= Html::tag('a', FA::icon('check') . ' ' . Yii::t('feed', 'Removed items'), [
                    'class' => 'checker',
                    'ng-click' => 'toggleDeleted()',
                    'ng-class' => Json::encode(['checked' => new \yii\web\JsExpression('deleted === true')]),
                ]) ?>

                <hr>

                <script type="text/ng-template" id="section.html">
                    <?= Html::a('{{ sections[sect.slug].title }}', null, [
                        'ng-click' => 'setSection(sect)',
                    ]) ?>

                    <span class="dash">&ndash;</span>

                    <ul class="sub" ng-if="sect.sections">
                        <li ng-repeat="sect in sect.sections track by sect.slug"
                            ng-class="{'active': isOpenedSection(sect), 'deleted': sections[sect.slug].deleted === '1'}"
                            ng-include="'section.html'"></li>
                    </ul>
                </script>

                <ul class="sections opened">
                    <li ng-repeat="sect in sections_tree track by sect.slug"
                        ng-class="{'active': isOpenedSection(sect), 'deleted': sections[sect.slug].deleted === '1'}"
                        ng-include="'section.html'"></li>
                </ul>
            </div>
        </div>
        <div class="col-xs-9 com-sm-9 col-md-9 col-lg-10">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= Yii::t('feed', 'Items list') ?></h3>

                    <div class="box-section" ng-if="section">
                        Edit section:
                        <?= Html::a('{{ sections[section].title }}', null, [
                            'ng-click' => 'editSection(section)',
                            'title' => Yii::t('feed', 'Edit section')
                        ]) ?>

                        <?php
                        echo Html::tag('a', FA::icon('times'), [
                            'class' => 'text-red',
                            'title' => Yii::t('feed', 'Remove section'),
                            'ng-click' => 'removeSection(section, $event)',
                            'ng-show' => 'sections[section].deleted === "0"',
                        ]);
                        echo Html::tag('a', FA::icon('undo'), [
                            'class' => 'text-light-blue',
                            'title' => Yii::t('feed', 'Restore section'),
                            'ng-click' => 'restoreSection(section)',
                            'ng-show' => 'sections[section].deleted === "1"',
                        ]);
                        ?>
                    </div>

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
                                    'placeholder' => Yii::t('feed', 'Search'),
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
                    <?php
                    $options = [
                        'title' => Yii::t('feed', 'Edit item'),
                        'class' => 'box-item',
                        'ng-class' => '{deactivated:page.activated===0,deleted:page.deleted}',
                    ];
                    ?>
                    <div class="text-center text-italic text-light" ng-show="items.length === 0">
                        <?= Yii::t('feed', 'Items not found') ?>
                    </div>
                    <div ng-repeat="item in items track by item.id"
                        <?= Html::renderTagAttributes($options) ?>>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                <div class="preview-picture clickable" ng-click="editItem(item)">
                                    Preview<br>picture
                                </div>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1 activated">
                                <md-switch ng-model="item.activated"
                                           ng-true-value="1" ng-false-value="0"
                                           ng-change="toggleActivated(item)"
                                           title="Item {{ item.activated === 1 ? 'activated' : 'deactivated' }}"
                                           aria-label="Item {{ item.activated === 1 ? 'activated' : 'deactivated' }}">
                                </md-switch>

                                <br>

                                <?= Html::tag('div', '{{ item.sort }}', [
                                    'class' => 'sort',
                                    'title' => Yii::t('feed', 'Sort'),
                                ]) ?>
                            </div>
                            <div class="col-xs-8 col-sm-4 col-md-7 col-lg-7 contain">
                                <h3 class="clickable" ng-click="editItem(item)">
                                    {{ item.title }}
                                    <br>
                                    <small>{{ item.slug }}</small>
                                </h3>

                                <small>{{ item.updated_at * 1000 | date:'dd MMM yyyy HH:mm' }}</small>

                                <p ng-bind-html="item.content_preview" class="clickable" ng-click="editItem(item)"></p>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1 actions">
                                <?php
                                echo Html::tag('a', FA::icon('times'), [
                                    'class' => 'text-red',
                                    'title' => Yii::t('feed', 'Remove item'),
                                    'ng-click' => 'removeItem(item, $event)',
                                    'ng-show' => '!item.deleted',
                                ]);
                                echo Html::tag('a', FA::icon('undo'), [
                                    'class' => 'text-light-blue',
                                    'title' => Yii::t('feed', 'Restore item'),
                                    'ng-click' => 'restoreItem(item)',
                                    'ng-show' => 'item.deleted',
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
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

    <md-fab-speed-dial md-open="fab.isOpen" md-direction="{{fab.selectedDirection}}" ng-class="fab.selectedMode">
        <md-fab-trigger>
            <?php
            echo Material::button(FA::icon('plus')->fixedWidth(), [
                'class' => 'md-fab md-warn',
                'aria-label' => 'menu',
            ]);
            ?>
        </md-fab-trigger>
        <md-fab-actions>
            <?php

            $tooltip = Material::tooltip(Yii::t('feed', 'Create new section'), [
                'md-direction' => 'left',
            ]);

            echo Material::button($tooltip . FA::icon('folder-o')->fixedWidth(), [
                'class' => 'md-fab md-raised md-mini',
                'title' => Yii::t('feed', 'Create new section'),
                'ng-click' => 'addSection()',
                'aria-label' => 'Add section',
            ]);

            $tooltip = Material::tooltip(Yii::t('feed', 'Create new item'), [
                'md-direction' => 'left',
            ]);

            echo Material::button($tooltip . FA::icon('file-o')->fixedWidth(), [
                'class' => 'md-fab md-raised md-mini',
                'title' => Yii::t('feed', 'Create new item'),
                'ng-click' => 'addItem()',
                'aria-label' => 'Add item',
            ]);

            ?>
        </md-fab-actions>
    </md-fab-speed-dial>
</section>