<?php
/**
 * _general.php
 * @author Revin Roman http://phptime.ru
 *
 * @var yii\web\View $this
 * @var Account\forms\AccountEditForm $AccountEditForm
 */

use backend\modules\Account;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var \common\widgets\angular\ActiveForm $form */
$form = \common\widgets\angular\ActiveForm::begin([
    'name' => 'AccountEditForm',
    'action' => $AccountEditForm->formAction(),
]);

?>

    <div class="box general">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('account', 'General information') ?></h3>
        </div>

        <div class="box-body">
            <?php
            echo $form->field($AccountEditForm, 'name')
                ->textInput();

            echo $form->field($AccountEditForm, 'email')
                ->textInput();

            echo '<hr>';

            echo $form->field($AccountEditForm, 'new_password')
                ->passwordInput();

            echo $form->field($AccountEditForm, 'new_password_app')
                ->passwordInput();
            ?>
        </div>

        <div class="box-footer">
            <?php
            echo Html::submitButton(FA::icon('check') . ' ' . Yii::t('account', 'Save'), [
                'class' => 'btn btn-success',
                'ng-disabled' => 'in_progress',
            ]);

            echo Html::button(Yii::t('account', 'Cancel'), [
                'class' => 'btn btn-link',
                'ng-click' => 'reload()',
            ]);
            ?>
        </div>

        <div class="overlay" ng-if="inProgress">
            <?= FA::icon('cog')->spin() ?>
        </div>
    </div>

<?php

\common\widgets\angular\ActiveForm::end();
