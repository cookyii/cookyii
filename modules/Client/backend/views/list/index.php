<?php
/**
 * index.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 */

use cookyii\modules\Client;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Json;

$this->title = Yii::t('cookyii.client', 'Clients management');

Client\backend\assets\ListAssetBundle::register($this);

/**
 * @param string $type
 * @param string $label
 * @return string
 */
function sortLink($type, $label)
{
    $label .= ' ' . FA::icon('sort-numeric-desc', ['ng-show' => 'clients.sort.order === "-' . $type . '"']);
    $label .= ' ' . FA::icon('sort-numeric-asc', ['ng-show' => 'clients.sort.order === "' . $type . '"']);

    return Html::a($label, null, [
        'ng-click' => 'clients.sort.setOrder("' . $type . '")',
    ]);
}

?>

<section <?= Html::renderTagAttributes([
    'class' => 'content',
    'ng-controller' => 'client.ListController',
]) ?>>
    <div class="row">
        <div class="col-xs-3 com-sm-3 col-md-3 col-lg-2">
            <div class="box-filter">
                <h3><?= Yii::t('cookyii', 'Filter') ?></h3>

                <hr>

                <?= Html::tag('a', FA::icon('check') . ' ' . Yii::t('cookyii.client', 'Removed clients'), [
                    'class' => 'checker',
                    'ng-click' => 'clients.filter.toggleDeleted()',
                    'ng-class' => Json::encode(['checked' => new \yii\web\JsExpression('clients.filter.deleted')]),
                ]) ?>
            </div>
        </div>
        <div class="col-xs-9 com-sm-9 col-md-9 col-lg-10">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <?= Yii::t('cookyii.client', 'Clients list') ?>

                        <a ng-click="clients.reload()" class="btn-reload pull-right">
                            <?= FA::icon('refresh', ['ng-class' => '{"fa-spin": accounts.inProgress}']) ?>
                        </a>
                    </h3>

                    <div class="box-tools">
                        <?= Html::tag('pagination', null, [
                            'class' => 'pagination pagination-sm no-margin pull-right',
                            'ng-model' => 'clients.pagination.currentPage',
                            'total-items' => 'clients.pagination.totalCount',
                            'items-per-page' => 'clients.pagination.perPage',
                            'ng-change' => 'clients.doPageChanged()',
                            'max-size' => '10',
                            'previous-text' => '‹',
                            'next-text' => '›',
                        ]) ?>

                        <form ng-submit="clients.filter.search.do()" class="pull-right">
                            <div class="input-group search" ng-class="{'wide':clients.filter.search.query.length>0}">
                                <?= Html::textInput(null, null, [
                                    'class' => 'form-control input-sm pull-right',
                                    'placeholder' => Yii::t('cookyii', 'Search'),
                                    'maxlength' => 100,
                                    'ng-model' => 'clients.filter.search.query',
                                    'ng-blur' => 'clients.filter.search.do()',
                                ]) ?>
                                <a ng-click="clients.filter.search.clear()" ng-show="clients.filter.search.query"
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
                    <table class="table table-hover table-clients">
                        <thead>
                        <tr>
                            <td class="id"><?= sortLink('id', Yii::t('cookyii.client', 'ID')) ?></td>
                            <td class="name"><?= sortLink('name', Yii::t('cookyii.client', 'Name')) ?></td>
                            <td class="email"><?= sortLink('email', Yii::t('cookyii.client', 'Email')) ?></td>
                            <td class="account"><?= Yii::t('cookyii.client', 'Account') ?></td>
                            <td class="updated"><?= sortLink('updated_at', Yii::t('cookyii.client', 'Updated at')) ?></td>
                            <td class="actions">&nbsp;</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-show="clients.list.length === 0">
                            <td colspan="6" class="text-center text-italic text-light">
                                <?= Yii::t('cookyii.client', 'Clients not found') ?>
                            </td>
                        </tr>
                        <?php
                        $options = [
                            'title' => Yii::t('cookyii.client', 'Edit client'),
                            'ng-class' => '{deleted:client.deleted}',
                        ];
                        ?>
                        <tr ng-repeat="client in clients.list track by client.id" <?= Html::renderTagAttributes($options) ?>>
                            <td class="id clickable" ng-click="clients.edit(client)">{{ client.id }}</td>
                            <td class="name clickable" ng-click="clients.edit(client)">{{ client.name }}</td>
                            <td class="email clickable" ng-click="clients.edit(client)">{{ client.email }}</td>
                            <td class="account clickable" ng-click="clients.edit(client)">
                                <span ng-show="!client.account" class="empty">Not set</span>
                                <span ng-show="client.account">#{{ client.account.id }} {{ client.account.name }}</span>
                            </td>
                            <td class="updated clickable" ng-click="clients.edit(client)">
                                {{ client.updated_at.format }}
                            </td>
                            <td class="actions">
                                <?php
                                echo Html::tag('a', FA::icon('times'), [
                                    'class' => 'text-red',
                                    'title' => Yii::t('cookyii.client', 'Remove client'),
                                    'ng-click' => 'clients.remove(client, $event)',
                                    'ng-show' => '!client.deleted',
                                ]);
                                echo Html::tag('a', FA::icon('undo'), [
                                    'class' => 'text-light-blue',
                                    'title' => Yii::t('cookyii.client', 'Restore client'),
                                    'ng-click' => 'clients.restore(client)',
                                    'ng-show' => 'client.deleted',
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
                        'ng-model' => 'clients.pagination.currentPage',
                        'total-items' => 'clients.pagination.totalCount',
                        'items-per-page' => 'clients.pagination.perPage',
                        'ng-change' => 'clients.doPageChanged()',
                        'max-size' => '10',
                        'previous-text' => '‹',
                        'next-text' => '›',
                    ]) ?>
                </div>
            </div>

            <div class="box-actions pull-right">
                <?php

                echo Html::tag('button', FA::icon('plus')->fixedWidth() . Yii::t('cookyii.client', 'Create new client'), [
                    'class' => 'btn btn-primary',
                    'ng-click' => 'clients.add()',
                    'aria-label' => 'Add client',
                ]);

                ?>
            </div>
        </div>
    </div>
</section>