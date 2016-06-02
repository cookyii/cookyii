<?php
/**
 * _general.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var Client\backend\forms\ClientEditForm $ClientEditForm
 */

use cookyii\modules\Client;
use cookyii\widgets\angular\ActiveForm;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var ActiveForm $form */
$form = ActiveForm::begin([
    'model' => $ClientEditForm,
    'controller' => 'client.EditController',
]);

?>

    <div class="box general">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('cookyii.client', 'General information') ?></h3>
        </div>

        <div class="box-body">
            <div class="form-group" ng-if="getClientId()">
                <label class="control-label" for="clienteditform-email">Account</label>

                <span ng-if="!data.account">
                    Not created. <?= Html::tag('a', 'Create', [
                        'data-action' => UrlManager()->createUrl(['/client/rest/client/create-account']),
                        'ng-click' => 'account.create($event)',
                    ]) ?>
                </span>
                <span ng-if="data.account">
                    #{{ data.account.id }} {{ data.account.name }} <?= Html::tag('a', 'unlink', [
                        'data-action' => UrlManager()->createUrl(['/client/rest/client/unlink-account']),
                        'ng-click' => 'account.unlink($event)',
                    ]) ?>
                </span>
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

ActiveForm::end();
