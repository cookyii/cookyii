<?php
/**
 * index.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var \yii\web\View $this
 * @var Account\forms\ForgotPasswordForm $ForgotPasswordForm
 */

use cookyii\modules\Account;
use cookyii\widgets\angular\ActiveForm;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

$this->title = \Yii::t('cookyii.account', 'Forgot password');

Account\frontend\assets\ForgotPasswordAssetBundle::register($this);

?>

<div class="box" ng-controller="ForgotPasswordController">
    <div class="box-logo">
        <?= Html::a(Html::tag('strong', APP_NAME), ['/']) ?>
    </div>

    <div class="box-body">
        <?php
        /** @var ActiveForm $form */
        $form = ActiveForm::begin([
            'model' => $ForgotPasswordForm,
        ]);

        echo $form->field($ForgotPasswordForm, 'email')
            ->icon('envelope')
            ->textInput([
                'placeholder' => $ForgotPasswordForm->getAttributeLabel('email'),
            ]);

        ?>
        <div class="row">
            <div class="col-xs-12 text-right">
                <?php
                $icon = FA::icon('cog', ['ng-show' => 'in_progress', 'class' => 'wo-animate'])->spin();

                echo Html::submitButton($icon . ' ' . Yii::t('cookyii.account', 'Reset password'), [
                    'class' => 'btn btn-sm btn-primary btn-flat',
                    'ng-disabled' => 'in_progress',
                ]);
                ?>
            </div>
        </div>
        <?php
        ActiveForm::end();
        ?>

        <?= Html::a(Yii::t('cookyii.account', 'Sign in'), ['/account/sign/in']) ?><br>
        <?= Html::a(Yii::t('cookyii.account', 'Sign up'), ['/account/sign/up']) ?>
    </div>
</div>