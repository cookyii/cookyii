<?php
/**
 * fill.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var \yii\web\View $this
 * @var Account\frontend\forms\FillAttributesForm $FillAttributesForm
 */

use cookyii\modules\Account;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

Account\frontend\assets\FillAttributesAssetBundle::register($this);

?>

<div class="box" ng-controller="FillAttributesController">
    <div class="box-logo">
        <?= Yii::t('account', 'To complete the registration you must specify your email') ?>
    </div>

    <div class="box-body">
        <?php
        /** @var \cookyii\widgets\angular\ActiveForm $form */
        $form = \cookyii\widgets\angular\ActiveForm::begin([
            'model' => $FillAttributesForm,
        ]);

        echo $form->field($FillAttributesForm, 'email')
            ->label(false)
            ->icon('envelope')
            ->textInput([
                'placeholder' => $FillAttributesForm->getAttributeLabel('email'),
            ]);

        ?>
        <div class="row">
            <div class="col-xs-8">
            </div>
            <div class="col-xs-4">
                <?php
                $icon = FA::icon('cog', ['ng-show' => 'in_progress', 'class' => 'wo-animate'])->spin();

                echo Html::submitButton($icon . ' ' . Yii::t('account', 'Sign In'), [
                    'class' => 'btn btn-sm btn-primary btn-block btn-flat',
                    'ng-disabled' => 'in_progress',
                ]);
                ?>
            </div>
        </div>
        <?php
        \cookyii\widgets\angular\ActiveForm::end();
        ?>
    </div>
</div>
