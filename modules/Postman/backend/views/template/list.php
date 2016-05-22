<?php
/**
 * list.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 */

use cookyii\modules\Postman;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Json;

$this->title = Yii::t('cookyii.postman', 'Message templates management');

Postman\backend\assets\TemplateListAssetBundle::register($this);

/**
 * @param string $type
 * @param string $label
 * @return string
 */
function sortLink($type, $label)
{
    $label .= ' ' . FA::icon('sort-numeric-desc', ['ng-show' => 'templates.sort.order === "-' . $type . '"']);
    $label .= ' ' . FA::icon('sort-numeric-asc', ['ng-show' => 'templates.sort.order === "' . $type . '"']);

    return Html::a($label, null, [
        'ng-click' => 'templates.sort.setOrder("' . $type . '")',
    ]);
}

?>

<section <?= Html::renderTagAttributes([
    'class' => 'content',
    'ng-controller' => 'postman.template.ListController',
]) ?>>
    <div class="row">
        <div class="col-xs-3 com-sm-3 col-md-3 col-lg-2">
            <div class="box-filter">
                <h3><?= Yii::t('cookyii', 'Filter') ?></h3>

                <hr>

                <?= Html::tag('a', FA::icon('check') . ' ' . Yii::t('cookyii.postman', 'Removed templates'), [
                    'class' => 'checker',
                    'ng-click' => 'templates.filter.toggleDeleted()',
                    'ng-class' => Json::encode(['checked' => new \yii\web\JsExpression('templates.filter.deleted')]),
                ]) ?>
            </div>
        </div>
        <div class="col-xs-9 com-sm-9 col-md-9 col-lg-10">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <?= Yii::t('cookyii.postman', 'Templates list') ?>

                        <a ng-click="templates.reload()" class="btn-reload pull-right">
                            <?= FA::icon('refresh', ['ng-class' => '{"fa-spin": accounts.inProgress}']) ?>
                        </a>
                    </h3>

                    <div class="box-tools">
                        <?= Html::tag('pagination', null, [
                            'class' => 'pagination pagination-sm no-margin pull-right',
                            'ng-model' => 'templates.pagination.currentPage',
                            'total-items' => 'templates.pagination.totalCount',
                            'items-per-page' => 'templates.pagination.perPage',
                            'ng-change' => 'templates.doPageChanged()',
                            'max-size' => '10',
                            'previous-text' => '‹',
                            'next-text' => '›',
                        ]) ?>

                        <form ng-submit="templates.filter.search.do()" class="pull-right">
                            <div class="input-group search" ng-class="{'wide':templates.filter.search.query.length>0}">
                                <?= Html::textInput(null, null, [
                                    'class' => 'form-control input-sm pull-right',
                                    'placeholder' => Yii::t('cookyii', 'Search'),
                                    'maxlength' => 100,
                                    'ng-model' => 'templates.filter.search.query',
                                    'ng-blur' => 'templates.filter.search.do()',
                                ]) ?>
                                <a ng-click="templates.filter.search.clear()" ng-show="templates.filter.search.query"
                                   class="clear-search">
                                    <?= FA::icon('times') ?>
                                </a>

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="box-body no-padding">
                    <table class="table table-hover table-templates">
                        <thead>
                        <tr>
                            <td class="id"><?= sortLink('id', Yii::t('cookyii.postman', 'ID')) ?></td>
                            <td class="code"><?= sortLink('code', Yii::t('cookyii.postman', 'Code')) ?></td>
                            <td class="subject"><?= sortLink('subject', Yii::t('cookyii.postman', 'Subject')) ?></td>
                            <td class="updated"><?= sortLink('updated_at', Yii::t('cookyii.postman', 'Updated at')) ?></td>
                            <td class="actions">&nbsp;</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-show="templates.length === 0">
                            <td colspan="6" class="text-center text-italic text-light">
                                <?= Yii::t('cookyii.postman', 'Templates not found') ?>
                            </td>
                        </tr>
                        <?php
                        $options = [
                            'title' => Yii::t('cookyii.postman', 'Edit template'),
                            'ng-class' => '{deleted:template.deleted}',
                        ];
                        ?>
                        <tr ng-repeat="template in templates.list track by template.id" <?= Html::renderTagAttributes($options) ?>>
                            <td class="id clickable" ng-click="templates.edit(template)">{{ template.id }}</td>
                            <td class="code clickable" ng-click="templates.edit(template)">{{ template.code }}</td>
                            <td class="subject clickable" ng-click="templates.edit(template)">{{ template.subject }}
                            </td>
                            <td class="updated clickable" ng-click="templates.edit(template)">
                                {{ template.updated_at * 1000 | date:'dd MMM yyyy HH:mm' }}
                            </td>
                            <td class="actions">
                                <?php
                                echo Html::tag('a', FA::icon('times'), [
                                    'class' => 'text-red',
                                    'title' => Yii::t('cookyii.postman', 'Remove template'),
                                    'ng-click' => 'templates.remove(template, $event)',
                                    'ng-show' => '!template.deleted',
                                ]);
                                echo Html::tag('a', FA::icon('undo'), [
                                    'class' => 'text-light-blue',
                                    'title' => Yii::t('cookyii.postman', 'Restore template'),
                                    'ng-click' => 'templates.restore(template)',
                                    'ng-show' => 'template.deleted',
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
                        'ng-model' => 'templates.pagination.currentPage',
                        'total-items' => 'templates.pagination.totalCount',
                        'items-per-page' => 'templates.pagination.perPage',
                        'ng-change' => 'templates.doPageChanged()',
                        'max-size' => '10',
                        'previous-text' => '‹',
                        'next-text' => '›',
                    ]) ?>
                </div>
            </div>

            <div class="box-actions pull-right">
                <?php

                echo Html::tag('button', FA::icon('plus')->fixedWidth() . Yii::t('cookyii.postman', 'Create new template'), [
                    'class' => 'btn btn-primary',
                    'ng-click' => 'templates.add()',
                    'aria-label' => 'Add template',
                ]);

                ?>
            </div>
        </div>
    </div>
</section>