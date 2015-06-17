<?php
/**
 * _rbac.php
 * @author Revin Roman http://phptime.ru
 */

use backend\modules\Account;
use yii\helpers\Html;

?>

    <div class="box rbac">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('account', 'Roles') ?></h3>
        </div>

        <div class="box-body">
            <?
            foreach (\resources\User::getAllRoles() as $role => $label) {
                $options = [
                    'ng-model' => sprintf('data.roles.%s', $role),
                    'value' => $role,
                ];

                if ($role === \common\Roles::USER) {
                    $options['disabled'] = true;
                }

                echo Html::tag('md-checkbox', $label, $options);
            }
            ?>
        </div>
    </div>

<?php

/**
 * @param array $permissions
 * @param \common\widgets\angular\ActiveForm $form
 * @param Account\forms\AccountEditForm $AccountEditForm
 * @return string
 */
function renderPermissionLevel($permissions, $form, $AccountEditForm)
{
    ob_start();

    if (isset($permissions['items']) && !empty($permissions['items'])) {
        foreach ($permissions['items'] as $permission => $description) {
            echo $form->field($AccountEditForm, 'permissions[' . $permission . ']', [
                'class' => 'common\widgets\angular\material\ActiveField',
                'options' => ['class' => 'form-group narrow'],
            ])
                ->label(false)
                ->checkbox([
                    'class' => 'permissions checkbox-list',
                    'ng-model' => 'data.permissions["' . $permission . '"]',
                    'label' => $permission,
                    'title' => $description,
                ]);
        }
    }

    if (isset($permissions['children']) && !empty($permissions['children'])) {
        foreach ($permissions['children'] as $prefix => $conf) {
            $icon = Html::tag('i', null, [
                'class' => 'fa fa-fw',
                'ng-class' => sprintf('{"fa-chevron-down": rbacOpened["%1$s"],"fa-chevron-right": !rbacOpened["%1$s"]}', $prefix),
            ]);

            echo Html::tag('a', sprintf('%s %s', $icon, $prefix), [
                'ng-click' => sprintf('toggleRbacGroup("%s")', $prefix),
            ]);

            echo Html::tag('div', renderPermissionLevel($conf, $form, $AccountEditForm), [
                'ng-show' => sprintf('rbacOpened["%s"]', $prefix),
            ]);
        }
    }

    return Html::tag('div', ob_get_clean(), ['class' => 'level']);
}