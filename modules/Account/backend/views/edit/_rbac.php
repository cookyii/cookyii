<?php
/**
 * _rbac.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 */

use yii\helpers\Html;

?>

    <div class="box rbac" ng-controller="AccountRolesController">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('account', 'Roles') ?></h3>
        </div>

        <div class="box-body">
            <?
            foreach (\resources\Account::getAllRoles() as $role => $label) {
                $options = [
                    'ng-change' => 'saveRoles()',
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