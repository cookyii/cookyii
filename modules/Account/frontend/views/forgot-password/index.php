<?php
/**
 * index.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var \yii\web\View $this
 * @var Account\frontend\forms\ForgotPasswordForm $ForgotPasswordForm
 */

use cookyii\modules\Account;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

$this->title = \Yii::t('account', 'Forgot password');

Account\frontend\assets\ForgotPasswordAssetBundle::register($this);

?>

<div class="box" ng-controller="ForgotPasswordController">
    <div class="box-logo">
        <?= Html::a(Html::img('/img/cookyii.png') . ' <strong>COOKYII</strong>frontend', ['/']) ?>
    </div>

    <div class="box-body">
        <?php
        /** @var \cookyii\widgets\angular\ActiveForm $form */
        $form = \cookyii\widgets\angular\ActiveForm::begin([
            'name' => 'ForgotPasswordForm',
            'action' => $ForgotPasswordForm->formAction(),
        ]);

        echo $form->field($ForgotPasswordForm, 'email')
            ->label(false)
            ->icon('envelope')
            ->textInput([
                'placeholder' => $ForgotPasswordForm->getAttributeLabel('email'),
            ]);

        ?>
        <div class="row">
            <div class="col-xs-12 text-right">
                <?php
                $icon = FA::icon('cog', ['ng-show' => 'in_progress', 'class' => 'wo-animate'])->spin();

                echo Html::submitButton($icon . ' ' . Yii::t('account', 'Reset password'), [
                    'class' => 'btn btn-sm btn-primary btn-flat',
                    'ng-disabled' => 'in_progress',
                ]);
                ?>
            </div>
        </div>
        <?php
        \cookyii\widgets\angular\ActiveForm::end();
        ?>

        <?= Html::a(Yii::t('account', 'Sign in'), ['/account/sign/in']) ?><br>
        <?= Html::a(Yii::t('account', 'Sign up'), ['/account/sign/up']) ?>
    </div>
</div>