<?php
/**
 * index.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 */

use cookyii\modules\Account;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Json;

$this->title = Yii::t('cookyii.account', 'Accounts management');

Account\backend\assets\ListAssetBundle::register($this);

/**
 * @param string $type
 * @param string $label
 * @return string
 */
function sortLink($type, $label)
{
    $label .= ' ' . FA::icon('sort-numeric-desc', ['ng-show' => 'accounts.sort.order === "-' . $type . '"']);
    $label .= ' ' . FA::icon('sort-numeric-asc', ['ng-show' => 'accounts.sort.order === "' . $type . '"']);

    return Html::a($label, null, [
        'ng-click' => 'accounts.sort.setOrder("' . $type . '")',
    ]);
}

?>

<section <?= Html::renderTagAttributes([
    'class' => 'content',
    'ng-controller' => 'AccountListController',
]) ?>>
    <div class="row">
        <div class="col-xs-3 com-sm-3 col-md-3 col-lg-2">
            <div class="box-filter">
                <h3><?= Yii::t('cookyii', 'Filter') ?></h3>

                <hr>

                <?= Html::tag('a', FA::icon('check') . ' ' . Yii::t('cookyii.account', 'Removed accounts'), [
                    'class' => 'checker',
                    'ng-click' => 'accounts.filter.toggleDeleted()',
                    'ng-class' => Json::encode(['checked' => new \yii\web\JsExpression('accounts.filter.deleted')]),
                ]) ?>
            </div>
        </div>
        <div class="col-xs-9 com-sm-9 col-md-9 col-lg-10">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <?= Yii::t('cookyii.account', 'Accounts list') ?>

                        <a ng-click="accounts.reload()" class="btn-reload pull-right">
                            <?= FA::icon('refresh', ['ng-class' => '{"fa-spin": accounts.inProgress}']) ?>
                        </a>
                    </h3>

                    <div class="box-tools">
                        <?= Html::tag('pagination', null, [
                            'class' => 'pagination pagination-sm no-margin pull-right',
                            'ng-model' => 'accounts.pagination.currentPage',
                            'total-items' => 'accounts.pagination.totalCount',
                            'items-per-page' => 'accounts.pagination.perPage',
                            'ng-change' => 'accounts.doPageChanged()',
                            'max-size' => '10',
                            'previous-text' => '‹',
                            'next-text' => '›',
                        ]) ?>


                        <form ng-submit="accounts.filter.search.do()" class="pull-right">
                            <div class="input-group search" ng-class="{'wide':accounts.filter.search.query.length>0}">
                                <?= Html::textInput(null, null, [
                                    'class' => 'form-control input-sm pull-right',
                                    'placeholder' => Yii::t('cookyii', 'Search'),
                                    'maxlength' => 100,
                                    'ng-model' => 'accounts.filter.search.query',
                                    'ng-blur' => 'accounts.filter.search.do()',
                                ]) ?>
                                <a ng-click="accounts.filter.search.clear()" ng-show="accounts.filter.search.query"
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
                    <table class="table table-hover table-accounts">
                        <thead>
                        <tr>
                            <td class="activated">&nbsp;</td>
                            <td class="id"><?= sortLink('id', Yii::t('cookyii.account', 'ID')) ?></td>
                            <td class="name"><?= sortLink('name', Yii::t('cookyii.account', 'Name')) ?></td>
                            <td class="email"><?= sortLink('email', Yii::t('cookyii.account', 'Email')) ?></td>
                            <td class="updated"><?= sortLink('updated_at', Yii::t('cookyii.account', 'Updated at')) ?></td>
                            <td class="actions">&nbsp;</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-show="accounts.list.length === 0">
                            <td colspan="6" class="text-center text-italic text-light">
                                <?= Yii::t('cookyii.account', 'Accounts not found') ?>
                            </td>
                        </tr>
                        <?php
                        $options = [
                            'title' => Yii::t('cookyii.account', 'Edit account'),
                            'ng-class' => '{deactivated:!account.activated,deleted:account.deleted}',
                        ];
                        ?>
                        <tr ng-repeat="account in accounts.list track by account.id" <?= Html::renderTagAttributes($options) ?>>
                            <td class="activated clickable">
                                <md-switch ng-model="account.activated"
                                           ng-change="accounts.toggleActivated(account)"
                                           ng-disabled="account.deleted"
                                           title="Account {{ account.activated ? 'activated' : 'deactivated' }}"
                                           aria-label="Account {{ account.activated ? 'activated' : 'deactivated' }}">
                                </md-switch>
                            </td>
                            <td class="id clickable" ng-click="accounts.edit(account)">{{ account.id }}</td>
                            <td class="name clickable" ng-click="accounts.edit(account)">{{ account.name }}</td>
                            <td class="email clickable" ng-click="accounts.edit(account)">{{ account.email }}</td>
                            <td class="updated clickable" ng-click="accounts.edit(account)">
                                {{ account.updated_at * 1000 | date:'dd MMM yyyy HH:mm' }}
                            </td>
                            <td class="actions">
                                <?php
                                echo Html::tag('a', FA::icon('times'), [
                                    'class' => 'text-red',
                                    'title' => Yii::t('cookyii.account', 'Remove account'),
                                    'ng-click' => 'accounts.remove(account, $event)',
                                    'ng-show' => '!account.deleted',
                                ]);
                                echo Html::tag('a', FA::icon('undo'), [
                                    'class' => 'text-light-blue',
                                    'title' => Yii::t('cookyii.account', 'Restore account'),
                                    'ng-click' => 'accounts.restore(account)',
                                    'ng-show' => 'account.deleted',
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
                        'ng-model' => 'accounts.pagination.currentPage',
                        'total-items' => 'accounts.pagination.totalCount',
                        'items-per-page' => 'accounts.pagination.perPage',
                        'ng-change' => 'accounts.doPageChanged()',
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
        'title' => Yii::t('cookyii.account', 'Create new account'),
        'ng-click' => 'accounts.add()',
        'aria-label' => 'Add account',
    ]);
    ?>
</section>