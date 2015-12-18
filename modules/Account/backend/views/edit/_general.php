<?php
/**
 * _general.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var Account\backend\forms\AccountEditForm $AccountEditForm
 */

use cookyii\modules\Account;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var \cookyii\widgets\angular\ActiveForm $form */
$form = \cookyii\widgets\angular\ActiveForm::begin([
    'model' => $AccountEditForm,
    'controller' => 'AccountEditController',
]);

?>

    <div class="box general">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('cookyii.account', 'General information') ?></h3>
        </div>

        <div class="box-body">
            <?php
            echo $form->field($AccountEditForm, 'name')
                ->textInput();

            echo $form->field($AccountEditForm, 'email')
                ->textInput();

            echo $form->field($AccountEditForm, 'gender')
                ->radioList($AccountEditForm::getGenderValues());

            echo '<hr>';

            echo Html::tag('label', Yii::t('cookyii.account', 'Roles'));

            echo $form->field($AccountEditForm, 'roles')
                ->checkboxList($AccountEditForm::getRoleValues());

            echo '<hr>';

            echo $form->field($AccountEditForm, 'new_password')
                ->passwordInput();

            echo $form->field($AccountEditForm, 'new_password_app')
                ->passwordInput();
            ?>
        </div>

        <div class="box-footer">
            <?php
            echo Html::submitButton(FA::icon('check') . ' ' . Yii::t('cookyii', 'Save'), [
                'class' => 'btn btn-success',
                'ng-disabled' => 'in_progress',
            ]);

            echo Html::button(Yii::t('cookyii', 'Cancel'), [
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

\cookyii\widgets\angular\ActiveForm::end();
