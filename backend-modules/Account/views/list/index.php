<?php
/**
 * index.php
 * @author Revin Roman http://phptime.ru
 *
 * @var yii\web\View $this
 * @var Account\forms\AccountEditForm $AccountEditForm
 */

use backend\modules\Account;
use common\widgets\Modal;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = Yii::t('account', 'Accounts management');

Account\views\_assets\ListAssetBundle::register($this);

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

$r = \resources\User::getAllRoles();

$roles = [
    'all' => Yii::t('account', 'All roles'),
    \common\Roles::ADMIN => Yii::t('account', 'Administrators'),
    \common\Roles::MANAGER => Yii::t('account', 'Managers'),
    \common\Roles::CLIENT => Yii::t('account', 'Clients'),
    \common\Roles::USER => Yii::t('account', 'Users'),
];

?>

    <section <?= Html::renderTagAttributes([
        'class' => 'content',
        'ng-controller' => 'UserListController',
    ]) ?>>
        <div class="row">
            <div class="col-xs-3 com-sm-3 col-md-3 col-lg-2">
                <div class="box-filter">
                    <h3><?= Yii::t('account', 'Filter') ?></h3>

                    <hr>

                    <ul>
                        <?
                        foreach ($roles as $role => $label) {
                            $encode_role = Json::encode($role);

                            $anchor = Html::tag('a', $label, [
                                'ng-click' => sprintf('setRole(%s)', $encode_role),
                            ]);

                            $options = [
                                'ng-class' => Json::encode(['selected' => new \yii\web\JsExpression(sprintf('role === %s', $encode_role))]),
                            ];

                            if ($role === 'all') {
                                Html::addCssClass($options, 'pad');
                            }

                            echo Html::tag('li', $anchor, $options);
                        }
                        ?>
                    </ul>

                    <hr>

                    <?= Html::tag('a', FA::icon('check') . ' ' . Yii::t('account', 'Removed accounts'), [
                        'ng-click' => 'toggleDeleted()',
                        'ng-class' => Json::encode(['selected' => new \yii\web\JsExpression('deleted === true')]),
                    ]) ?>
                </div>
            </div>
            <div class="col-xs-9 com-sm-9 col-md-9 col-lg-10">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Accounts list</h3>

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
                                        'placeholder' => Yii::t('account', 'Search'),
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
                        <table class="table table-hover table-accounts">
                            <thead>
                            <tr>
                                <td class="activated">&nbsp;</td>
                                <td class="id"><?= sortLink('id', Yii::t('account', 'ID')) ?></td>
                                <td class="name"><?= sortLink('name', Yii::t('account', 'Имя')) ?></td>
                                <td class="email"><?= sortLink('email', Yii::t('account', 'Email')) ?></td>
                                <td class="updated"><?= sortLink('updated_at', Yii::t('account', 'Изменён')) ?></td>
                                <td class="actions">&nbsp;</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $options = [
                                'title' => Yii::t('account', 'Edit account'),
                                'ng-class' => '{deactivated:user.activated===0,deleted:user.deleted}',
                            ];
                            ?>
                            <tr ng-show="users.length === 0">
                                <td colspan="6" class="text-center text-italic text-light">
                                    <?= Yii::t('account', 'Accounts not found') ?>
                                </td>
                            </tr>
                            <tr ng-repeat="user in users track by user.id" <?= Html::renderTagAttributes($options) ?>>
                                <td class="activated clickable">
                                    <md-switch ng-model="user.activated"
                                               ng-true-value="1" ng-false-value="0"
                                               ng-change="toggleActivated(user)"
                                               title="User active"
                                               aria-label="User active">
                                    </md-switch>
                                </td>
                                <td class="id clickable" ng-click="edit(user)">{{ user.id }}</td>
                                <td class="name clickable" ng-click="edit(user)">{{ user.name }}</td>
                                <td class="email clickable" ng-click="edit(user)">{{ user.email }}</td>
                                <td class="updated clickable" ng-click="edit(user)">
                                    {{ user.updated_at * 1000 | date:'dd MMM yyyy HH:mm' }}
                                </td>
                                <td class="actions">
                                    <?
                                    echo Html::tag('a', FA::icon('times'), [
                                        'class' => 'text-red',
                                        'title' => Yii::t('account', 'Remove account'),
                                        'ng-click' => 'remove(user)',
                                        'ng-show' => '!user.deleted',
                                    ]);
                                    echo Html::tag('a', FA::icon('undo'), [
                                        'class' => 'text-light-blue',
                                        'title' => Yii::t('account', 'Restore account'),
                                        'ng-click' => 'restore(user)',
                                        'ng-show' => 'user.deleted',
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

        <?
        echo Html::tag('md-button', FA::icon('plus')->fixedWidth(), [
            'class' => 'md-warn md-fab md-fab-bottom-right',
            'title' => Yii::t('account', 'Create new account'),
            'ng-click' => 'addUser()',
            'aria-label' => 'Add user',
        ]);
        ?>
    </section>

<?

$angular_options = [
    'url' => [
        'get' => Url::toRoute(['/rest/account/get']),
        'edit' => Url::toRoute(['/rest/account/edit']),
    ]
];

echo Modal::widget([
    'id' => 'AccountEditFormModal',
    'options' => [
        'ng-controller' => 'UserEditController',
        'ng-init' => 'init(' . Json::encode($angular_options) . ')',
    ],
    'header' => Html::tag('h3', Yii::t('account', 'Account information')),
    'content' => function () use ($AccountEditForm) {
        /** @var \common\widgets\angular\ActiveForm $form */
        $form = \common\widgets\angular\ActiveForm::begin([
            'name' => 'AccountEditForm',
            'action' => $AccountEditForm->formAction(),
        ]);

        ?>
        <div class="row">
            <div class="col-lg-12">
                <?
                echo $form->field($AccountEditForm, 'name')
                    ->label(false)
                    ->textInput(['placeholder' => $AccountEditForm->getAttributeLabel('name')]);

                echo $form->field($AccountEditForm, 'email')
                    ->label(false)
                    ->textInput(['placeholder' => $AccountEditForm->getAttributeLabel('email')]);

                echo Html::tag('strong', Yii::t('account', 'Роли пользователя'));

                echo $form->field($AccountEditForm, 'roles', [
                    'class' => 'common\widgets\angular\material\ActiveField',
                    'options' => ['class' => 'form-group narrow'],
                ])
                    ->label(false)
                    ->checkboxList(Account\forms\AccountEditForm::getRoleValues(), ['class' => 'roles checkbox-list'], [
                        'user' => ['disabled' => true],
                    ]);
                ?>
            </div>
        </div>

        <hr>

        <?

        echo Html::submitButton(FA::icon('check') . ' ' . Yii::t('account', 'Сохранить'), [
            'class' => 'btn btn-primary',
            'ng-disabled' => 'in_progress',
        ]);

        echo Html::resetButton(Yii::t('account', 'Отменить'), [
            'class' => 'btn btn-link'
        ]);

        \common\widgets\angular\ActiveForm::end();
    }
]);
