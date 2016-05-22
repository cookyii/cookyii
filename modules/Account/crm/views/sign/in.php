<?php
/**
 * in.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var \yii\web\View $this
 * @var Account\forms\SignInForm $SignInForm
 */

use cookyii\modules\Account;
use cookyii\widgets\angular\ActiveForm;
use rmrevin\yii\fontawesome\FA;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;

$this->title = \Yii::t('cookyii.account', 'Sign in');

Account\crm\assets\SignInAssetBundle::register($this);

?>

<div class="login-box" ng-controller="SignInController">
    <div class="login-logo">
        <strong>COOKYII</strong>CRM
    </div>

    <div class="login-box-body">
        <?php
        /** @var ActiveForm $form */
        $form = ActiveForm::begin([
            'model' => $SignInForm,
        ]);

        echo $form->field($SignInForm, 'email')
            ->icon('envelope')
            ->textInput();

        echo $form->field($SignInForm, 'password')
            ->icon('lock')
            ->passwordInput();

        ?>
        <div class="row">
            <div class="col-xs-8" style="padding-top: 10px;">
                <?php
                echo $form->field($SignInForm, 'remember')
                    ->label(false)
                    ->checkbox(['ng-icheck' => true]);
                ?>
            </div>
            <div class="col-xs-4">
                <?php
                $icon = FA::icon('cog', ['ng-show' => 'in_progress', 'class' => 'wo-animate'])->spin();

                echo Html::submitButton($icon . ' ' . Yii::t('cookyii.account', 'Sign in'), [
                    'class' => 'btn btn-primary btn-block btn-flat',
                    'ng-disabled' => 'in_progress',
                ]);
                ?>
            </div>
        </div>
        <?php
        ActiveForm::end();

        $authAuthChoice = AuthChoice::begin([
            'baseAuthUrl' => ['/account/sign/auth'],
            'popupMode' => false,
            'autoRender' => false,
        ]);

        $AuthAuthChoiceClients = $authAuthChoice->getClients();

        if (!empty($AuthAuthChoiceClients)) {
            ?>
            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <?php
                foreach ($authAuthChoice->getClients() as $Client) {
                    $name = $Client->getName();
                    $icon = $name;
                    if ($icon === 'live') {
                        $icon = 'windows';
                    }
                    if ($icon === 'vkontakte') {
                        $icon = 'vk';
                    }
                    if ($icon === 'yandex') {
                        $icon = 'yahoo';
                    }

                    $icon = FA::icon($icon);

                    echo Html::a(
                        sprintf('%s Sign in using %s', $icon, $Client->getName()),
                        $authAuthChoice->createClientUrl($Client),
                        [
                            'class' => sprintf('btn btn-block btn-flat btn-social btn-%s', $name),
                        ]
                    );
                }
                ?>
            </div>
            <?php
        }
        AuthChoice::end();

        ?>

        <a href="#">I forgot my password</a><br>
    </div>
</div>