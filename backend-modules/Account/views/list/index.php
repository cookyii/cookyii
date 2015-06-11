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
    \common\Roles::USER => [
        'label' => $r[\common\Roles::USER],
        'icon' => 'user',
        'class' => ''
    ],
    \common\Roles::MANAGER => [
        'label' => $r[\common\Roles::MANAGER],
        'icon' => 'user',
        'class' => ''
    ],
    \common\Roles::ADMIN => [
        'label' => $r[\common\Roles::ADMIN],
        'icon' => 'user',
        'class' => ''
    ],
    '|',
    'deleted' => [
        'label' => Yii::t('order', 'Удалённые пользователи'),
        'icon' => 'trash',
        'class' => null
    ],
    '|',
    'all' => [
        'label' => Yii::t('account', 'Весь список'),
        'icon' => null,
        'class' => null
    ],
];

?>

    <section <?= Html::renderTagAttributes([
        'class' => 'content',
        'ng-controller' => 'UserListController',
    ]) ?>>
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
                        'max-size' => '5',
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
                                'ng-blur' => 'toggleSearchFocus()',
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
                        'title' => Yii::t('account', 'Редактировать аккаунт'),
                        'ng-class' => '{deleted:user.deleted}',
                    ];
                    ?>
                    <tr ng-show="users.length === 0">
                        <td colspan="5" class="text-center text-italic text-light">
                            <?= Yii::t('account', 'Пользователи не найдены') ?>
                        </td>
                    </tr>
                    <tr ng-repeat="user in users" <?= Html::renderTagAttributes($options) ?>>
                        <td class="id clickable" ng-click="edit(user)">{{ user.id }}</td>
                        <td class="name clickable" ng-click="edit(user)">{{ user.name }}</td>
                        <td class="email clickable" ng-click="edit(user)">{{ user.email }}</td>
                        <td class="updated clickable" ng-click="edit(user)">
                            {{ user.updated_at * 1000 | date:'dd MMM yyyy HH:mm' }}
                        </td>
                        <td class="actions">
                            <?
                            echo Html::tag('a', FA::icon('times'), [
                                'class' => 'delete',
                                'title' => Yii::t('account', 'Удалить аккаунт'),
                                'ng-click' => 'remove(user)',
                                'ng-show' => '!user.deleted',
                            ]);
                            echo Html::tag('a', FA::icon('undo'), [
                                'title' => Yii::t('account', 'Восстановить аккаунт'),
                                'ng-click' => 'restore(user)',
                                'ng-show' => 'user.deleted',
                            ]);
                            ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?
        echo Html::tag('md-button', FA::icon('plus')->fixedWidth(), [
            'class' => 'md-warn md-fab md-fab-bottom-right',
            'title' => Yii::t('account', 'Create new account'),
            'ng-click' => 'addUser()',
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
    'header' => Html::tag('h3', Yii::t('account', 'Редактирование аккаунта')),
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

                echo $form->field($AccountEditForm, 'roles')
                    ->label(false)
                    ->checkboxList(Account\forms\AccountEditForm::getRoleValues(), ['class' => 'roles'], [
                        'user' => ['disabled' => true],
                    ]);


                ?>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-lg-12">
                <?
                echo $form->field($AccountEditForm, 'activated')
                    ->label(false)
                    ->checkbox();

                echo $form->field($AccountEditForm, 'deleted')
                    ->label(false)
                    ->checkbox();
                ?>
            </div>
        </div>
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
