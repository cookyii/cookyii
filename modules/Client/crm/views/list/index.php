<?php
/**
 * index.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 */

use cookyii\modules\Client;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Json;

$this->title = Yii::t('client', 'Clients management');

Client\crm\assets\ListAssetBundle::register($this);

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
    'ng-controller' => 'ClientListController',
]) ?>>
    <div class="row">
        <div class="col-xs-3 com-sm-3 col-md-3 col-lg-2">
            <div class="box-filter">
                <h3><?= Yii::t('client', 'Filter') ?></h3>

                <hr>

                <?= Html::tag('a', FA::icon('check') . ' ' . Yii::t('client', 'Removed clients'), [
                    'class' => 'checker',
                    'ng-click' => 'clients.filter.toggleDeleted()',
                    'ng-class' => Json::encode(['checked' => new \yii\web\JsExpression('clients.filter.deleted')]),
                ]) ?>
            </div>
        </div>
        <div class="col-xs-9 com-sm-9 col-md-9 col-lg-10">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= Yii::t('client', 'Clients list') ?></h3>

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
                                    'placeholder' => Yii::t('client', 'Search'),
                                    'maxlength' => 100,
                                    'ng-model' => 'clients.filter.search.query',
                                    'ng-blur' => 'clients.filter.search.do()',
                                    'ng-keydown' => 'clients.filter.search.do()',
                                ]) ?>
                                <a ng-click="clients.filter.search.clear()" ng-show="clients.filter.search.query"
                                   class="clear-search">
                                    <?= FA::icon('times') ?>
                                </a>

                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-default" ng-click="clients.filter.search.do()">
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
                            <td class="id"><?= sortLink('id', Yii::t('client', 'ID')) ?></td>
                            <td class="name"><?= sortLink('name', Yii::t('client', 'Name')) ?></td>
                            <td class="email"><?= sortLink('email', Yii::t('client', 'Email')) ?></td>
                            <td class="updated"><?= sortLink('updated_at', Yii::t('client', 'Updated at')) ?></td>
                            <td class="actions">&nbsp;</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-show="clients.list.length === 0">
                            <td colspan="6" class="text-center text-italic text-light">
                                <?= Yii::t('client', 'Clients not found') ?>
                            </td>
                        </tr>
                        <?php
                        $options = [
                            'title' => Yii::t('client', 'Edit client'),
                            'ng-class' => '{deleted:client.deleted}',
                        ];
                        ?>
                        <tr ng-repeat="client in clients.list track by client.id" <?= Html::renderTagAttributes($options) ?>>
                            <td class="id clickable" ng-click="clients.edit(client)">{{ client.id }}</td>
                            <td class="name clickable" ng-click="clients.edit(client)">{{ client.name }}</td>
                            <td class="email clickable" ng-click="clients.edit(client)">{{ client.email }}</td>
                            <td class="updated clickable" ng-click="clients.edit(client)">
                                {{ client.updated_at * 1000 | date:'dd MMM yyyy HH:mm' }}
                            </td>
                            <td class="actions">
                                <?php
                                echo Html::tag('a', FA::icon('times'), [
                                    'class' => 'text-red',
                                    'title' => Yii::t('client', 'Remove client'),
                                    'ng-click' => 'clients.remove(client, $event)',
                                    'ng-show' => '!client.deleted',
                                ]);
                                echo Html::tag('a', FA::icon('undo'), [
                                    'class' => 'text-light-blue',
                                    'title' => Yii::t('client', 'Restore client'),
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
        </div>
    </div>

    <?php
    echo Html::tag('md-button', FA::icon('plus')->fixedWidth(), [
        'class' => 'md-warn md-fab md-fab-bottom-right',
        'title' => Yii::t('client', 'Create new client'),
        'ng-click' => 'clients.add()',
        'aria-label' => 'Add client',
    ]);
    ?>
</section>