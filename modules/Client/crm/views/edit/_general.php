<?php
/**
 * _general.php
 * @author Revin Roman
 * @link https://rmrevin.com
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
            <div class="form-group" style="margin-bottom: -15px;">
                <label class="control-label" for="clienteditform-email">Account</label>

                <span ng-hide="data.account_id">Not created. <?= Html::tag('a', 'Create', [
                        'data-action' => UrlManager()->createUrl(['/client/rest/client/create-account']),
                        'ng-click' => 'account.create($event)',
                    ]) ?></span>
                <span ng-show="data.account_id">#{{ data.account.id }} {{ data.account.name }} <?= Html::tag('a', 'unlink', [
                        'data-action' => UrlManager()->createUrl(['/client/rest/client/unlink-account']),
                        'ng-click' => 'account.unlink($event)',
                    ]) ?></span>
            </div>

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
