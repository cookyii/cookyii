<?php
/**
 * list.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 *
 * @var yii\web\View $this
 */

use cookyii\modules\Postman;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Json;

$this->title = Yii::t('postman', 'Messages management');

Postman\backend\assets\MessageListAssetBundle::register($this);

/**
 * @param string $type
 * @param string $label
 * @return string
 */
function sortLink($type, $label)
{
    $label .= ' ' . FA::icon('sort-numeric-desc', ['ng-show' => 'messages.sort.order === "-' . $type . '"']);
    $label .= ' ' . FA::icon('sort-numeric-asc', ['ng-show' => 'messages.sort.order === "' . $type . '"']);

    return Html::a($label, null, [
        'ng-click' => 'messages.sort.setOrder("' . $type . '")',
    ]);
}

?>

<section <?= Html::renderTagAttributes([
    'class' => 'content',
    'ng-controller' => 'MessageListController',
]) ?>>
    <div class="row">
        <div class="col-xs-3 com-sm-3 col-md-3 col-lg-2">
            <div class="box-filter">
                <h3><?= Yii::t('postman', 'Filter') ?></h3>

                <hr>

                <?= Html::tag('a', FA::icon('check') . ' ' . Yii::t('postman', 'Removed messages'), [
                    'class' => 'checker',
                    'ng-click' => 'messages.filter.toggleDeleted()',
                    'ng-class' => Json::encode(['checked' => new \yii\web\JsExpression('messages.filter.deleted === true')]),
                ]) ?>
            </div>
        </div>
        <div class="col-xs-9 com-sm-9 col-md-9 col-lg-10">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= Yii::t('postman', 'Templates list') ?></h3>

                    <div class="box-tools">
                        <?= Html::tag('pagination', null, [
                            'class' => 'pagination pagination-sm no-margin pull-right',
                            'ng-model' => 'messages.pagination.currentPage',
                            'total-items' => 'messages.pagination.totalCount',
                            'items-per-page' => 'messages.pagination.perPage',
                            'ng-change' => 'messages.doPageChanged()',
                            'max-size' => '10',
                            'previous-text' => '‹',
                            'next-text' => '›',
                        ]) ?>

                        <form ng-submit="messages.filter.search.do()" class="pull-right">
                            <div class="input-group search" ng-class="{'wide':messages.filter.search.query.length>0}">
                                <?= Html::textInput(null, null, [
                                    'class' => 'form-control input-sm pull-right',
                                    'placeholder' => Yii::t('account', 'Search'),
                                    'maxlength' => 100,
                                    'ng-model' => 'messages.filter.search.query',
                                    'ng-blur' => 'messages.filter.search.do()',
                                    'ng-keydown' => 'messages.filter.search.do()',
                                ]) ?>
                                <a ng-click="messages.filter.search.clear()" ng-show="messages.filter.search.query"
                                   class="clear-search">
                                    <?= FA::icon('times') ?>
                                </a>

                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-default" ng-click="messages.filter.search.do()">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="box-body no-padding">
                    <table class="table table-hover table-messages">
                        <thead>
                        <tr>
                            <td class="id"><?= sortLink('id', Yii::t('postman', 'ID')) ?></td>
                            <td class="subject"><?= sortLink('subject', Yii::t('postman', 'Subject')) ?></td>
                            <td class="address"><?= Yii::t('postman', 'Address') ?></td>
                            <td class="created"><?= sortLink('created_at', Yii::t('postman', 'Created at')) ?></td>
                            <td class="sent"><?= sortLink('sent_at', Yii::t('postman', 'Sent at')) ?></td>
                            <td class="actions">&nbsp;</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-show="messages.list.length === 0">
                            <td colspan="6" class="text-center text-italic text-light">
                                <?= Yii::t('postman', 'Messages not found') ?>
                            </td>
                        </tr>
                        <?php
                        $options = [
                            'title' => Yii::t('postman', 'Edit message'),
                            'ng-class' => '{deactivated:message.activated===0,deleted:message.deleted}',
                        ];
                        ?>
                        <tr ng-repeat="message in messages.list track by message.id" <?= Html::renderTagAttributes($options) ?>>
                            <td class="id clickable" ng-click="messages.edit(message)">{{ message.id }}</td>
                            <td class="subject clickable" ng-click="messages.edit(message)">{{ message.subject }}</td>
                            <td class="address clickable" ng-click="messages.edit(message)">
                                <div class="empty-address text-italic text-light" ng-show="message.address.length <= 0">
                                    No address
                                </div>

                                <div class="address" ng-repeat="address in message.address">
                                    <span class="label label-default" ng-if="address.type === 1">reply to:</span>
                                    <span class="label label-success" ng-if="address.type === 2">to:</span>
                                    <span class="label label-default" ng-if="address.type === 3">cc:</span>
                                    <span class="label label-default" ng-if="address.type === 4">bcc:</span>
                                    {{ address.email }}
                                </div>
                            </td>
                            <td class="created clickable" ng-click="messages.edit(message)">
                                {{ message.created_at * 1000 | date:'dd MMM yyyy HH:mm' }}
                            </td>
                            <td class="sent clickable" ng-click="messages.edit(message)">
                                <?php
                                echo Html::tag('a', FA::icon('paper-plane'), [
                                    'class' => 'text-info resent',
                                    'title' => Yii::t('postman', 'Resent message'),
                                    'ng-click' => 'messages.resent(message, $event)',
                                    'ng-class' => '{invisible: message.deleted}',
                                ]);

                                echo Html::tag('span', 'in queue', [
                                    'class' => 'not-sent text-italic text-light',
                                    'ng-hide' => 'message.sent_at',
                                ]);

                                echo Html::tag('span', '{{ message.sent_at * 1000 | date:\'dd MMM yyyy HH:mm\' }}', [
                                    'class' => 'datetime',
                                    'ng-show' => 'message.sent_at',
                                ]);
                                ?>
                            </td>
                            <td class="actions">
                                <?php
                                echo Html::tag('a', FA::icon('times'), [
                                    'class' => 'text-red',
                                    'title' => Yii::t('postman', 'Remove message'),
                                    'ng-click' => 'messages.remove(message, $event)',
                                    'ng-show' => '!message.deleted',
                                ]);
                                echo Html::tag('a', FA::icon('undo'), [
                                    'class' => 'text-light-blue',
                                    'title' => Yii::t('postman', 'Restore message'),
                                    'ng-click' => 'messages.restore(message)',
                                    'ng-show' => 'message.deleted',
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
                        'ng-model' => 'messages.pagination.currentPage',
                        'total-items' => 'messages.pagination.totalCount',
                        'items-per-page' => 'messages.pagination.perPage',
                        'ng-change' => 'messages.doPageChanged()',
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
        'title' => Yii::t('postman', 'Create new message'),
        'ng-click' => 'messages.add()',
        'aria-label' => 'Add message',
    ]);
    ?>
</section>