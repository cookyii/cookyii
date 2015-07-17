<?php
/**
 * _general.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 * @var Client\crm\forms\ClientEditForm $ClientEditForm
 */

use cookyii\modules\Client;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var \cookyii\widgets\angular\ActiveForm $form */
$form = \cookyii\widgets\angular\ActiveForm::begin([
    'name' => 'ClientEditForm',
    'action' => $ClientEditForm->formAction(),
    'controller' => 'ClientEditController',
]);

?>

    <div class="box general">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('client', 'General information') ?></h3>
        </div>

        <div class="box-body">
            <?php
            echo $form->field($ClientEditForm, 'name')
                ->textInput();

            echo $form->field($ClientEditForm, 'email')
                ->textInput();

            echo $form->field($ClientEditForm, 'phone')
                ->textInput();
            ?>
        </div>

        <div class="box-footer">
            <?php
            echo Html::submitButton(FA::icon('check') . ' ' . Yii::t('client', 'Save'), [
                'class' => 'btn btn-success',
                'ng-disabled' => 'in_progress',
            ]);

            echo Html::button(Yii::t('client', 'Cancel'), [
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
