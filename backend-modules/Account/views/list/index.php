<?php
/**
 * index.php
 * @author Revin Roman http://phptime.ru
 *
 * @var yii\web\View $this
 * @var Account\forms\AccountEditForm $AccountEditForm
 */

use common\widgets\Modal;
use backend\modules\Account;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = Yii::t('account', 'Список аккаунтов');

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
    \backend\Permissions::ROLE_USER => [
        'label' => $r[\backend\Permissions::ROLE_USER],
        'icon' => 'user',
        'class' => ''
    ],
    \backend\Permissions::ROLE_MANAGER => [
        'label' => $r[\backend\Permissions::ROLE_MANAGER],
        'icon' => 'user',
        'class' => ''
    ],
    \backend\Permissions::ROLE_ADMIN => [
        'label' => $r[\backend\Permissions::ROLE_ADMIN],
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

$angular_options = [
    'url' => [
        'list' => Url::toRoute(['/rest/account/list']),
        'delete' => Url::toRoute(['/rest/account/delete']),
        'restore' => Url::toRoute(['/rest/account/restore']),
    ]
];

?>

    <div <?= Html::renderTagAttributes([
        'ng-controller' => 'UserListController',
        'ng-init' => 'init(' . Json::encode($angular_options) . ')',
    ]) ?>>
        <div class="mail-box-header">
            <div class="row">
                <div class="col-md-2"><h2><?= $this->title ?></h2></div>
                <div class="col-md-2">
                    <div class="btn-group pull-right">
                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle">
                            <?
                            foreach ($roles as $role => $data) {
                                if ($data !== '|') {
                                    $icon = empty($data['icon']) ? null : FA::icon($data['icon'], ['class' => $data['class']]);

                                    $label = $data['label'];
                                    if (mb_strlen($label, 'utf-8') > 15) {
                                        $label = mb_substr($label, 0, 15, 'utf-8') . '...';
                                    }

                                    echo Html::tag('span', $icon . ' ' . $label, [
                                        'ng-show' => 'role === "' . $role . '"',
                                    ]);
                                }
                            }
                            ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu credits-dropdown-filter-purchase">
                            <?
                            foreach ($roles as $role => $data) {
                                if ($data === '|') {
                                    echo '<li class="divider"></li>';
                                } else {
                                    $icon = empty($data['icon']) ? null : FA::icon($data['icon'], ['class' => $data['class']]);
                                    echo Html::tag('li', Html::a($icon . ' ' . $data['label'], null, [
                                        'ng-click' => 'setRole("' . $role . '")'
                                    ]));
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group m-b">
                        <?= Html::textInput(null, null, [
                            'class' => 'form-control',
                            'placeholder' => Yii::t('account', 'Поиск пользователя'),
                            'maxlength' => 100,
                            'ng-model' => 'search',
                        ]) ?>
                        <a ng-click="clearSearch()" ng-show="search" class="clear-search">
                            <?= FA::icon('times') ?>
                        </a>
                        <span class="input-group-btn">
                            <a class="btn btn-primary" ng-click="doSearch()"><i class="fa fa-search"></i></a>
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <?= Html::tag('pagination', null, [
                        'class' => 'pull-right',
                        'ng-show' => 'pagination.pageCount > 1',
                        'ng-model' => 'pagination.currentPage',
                        'total-items' => 'pagination.totalCount',
                        'items-per-page' => 'pagination.perPage',
                        'ng-change' => 'doPageChanged()',
                        'max-size' => '5',
                        'previous-text' => '‹',
                        'next-text' => '›',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="mail-box">
            <table class="table table-hover table-accounts">
                <thead>
                <tr>
                    <td class="id"><?= sortLink('id', Yii::t('account', 'ID')) ?></td>
                    <td class="email"><?= sortLink('email', Yii::t('account', 'Email')) ?></td>
                    <td class="name"><?= sortLink('name', Yii::t('account', 'Имя')) ?></td>
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
                    <td class="id clickable" ng-click="edit(user.id, $event)">{{ user.id }}</td>
                    <td class="email clickable" ng-click="edit(user.id, $event)">{{ user.email }}</td>
                    <td class="name clickable" ng-click="edit(user.id, $event)">
                        {{ user.name }}
                        <?= Html::tag('span', '{{ role_name }}', [
                            'class' => 'label',
                            'ng-repeat' => '(role, role_name) in user.roles',
                            'ng-class' => '"role-" + role'
                        ]) ?>
                    </td>
                    <td class="updated clickable" ng-click="edit(user.id, $event)">{{ user.updated_at }}</td>
                    <td class="actions">
                        <?
                        echo Html::a(FA::icon('times'), ['delete'], [
                            'class' => 'delete',
                            'title' => Yii::t('account', 'Удалить аккаунт'),
                            'ng-click' => 'delete(user.id, $event)',
                            'ng-show' => '!user.deleted',
                        ]);
                        echo Html::a(FA::icon('undo'), ['restore'], [
                            'title' => Yii::t('account', 'Восстановить аккаунт'),
                            'ng-click' => 'restore(user.id, $event)',
                            'ng-show' => 'user.deleted',
                        ]);
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <?
        echo Html::a(FA::icon('plus')->fixedWidth(), '#', [
            'class' => 'btn btn-danger btn-action',
            'title' => Yii::t('account', 'Создать новый аккаунт'),
            'ng-click' => 'addUser($event)',
        ]);
        ?>
    </div>

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
                    ->textInput();

                echo $form->field($AccountEditForm, 'email')
                    ->emailInput();

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
            'class' => 'btn btn-primary'
        ]);

        echo Html::resetButton(Yii::t('account', 'Отменить'), [
            'class' => 'btn btn-link'
        ]);

        \common\widgets\angular\ActiveForm::end();
    }
]);
