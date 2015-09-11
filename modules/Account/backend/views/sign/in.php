<?php
/**
 * in.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var \yii\web\View $this
 * @var Account\backend\forms\SignInForm $SignInForm
 */

use cookyii\modules\Account;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

$this->title = \Yii::t('account', 'Sing in');

Account\backend\assets\SignInAssetBundle::register($this);

?>

<div class="login-box" ng-controller="SignInController">
    <div class="login-logo">
        <img src="/img/cookyii.png"/>
        <strong>COOKYII</strong>BACKEND
    </div>

    <div class="login-box-body">
        <?php
        /** @var \cookyii\widgets\angular\ActiveForm $form */
        $form = \cookyii\widgets\angular\ActiveForm::begin([
            'name' => 'SignInForm',
            'action' => $SignInForm->formAction(),
        ]);

        echo $form->field($SignInForm, 'email')
            ->label(false)
            ->icon('envelope')
            ->textInput([
                'placeholder' => $SignInForm->getAttributeLabel('email'),
            ]);

        echo $form->field($SignInForm, 'password')
            ->label(false)
            ->icon('lock')
            ->passwordInput([
                'placeholder' => $SignInForm->getAttributeLabel('password'),
            ]);

        ?>
        <div class="row">
            <div class="col-xs-8">
                <?php
                echo $form->field($SignInForm, 'remember', ['class' => 'cookyii\widgets\angular\material\ActiveField'])
                    ->label(false)
                    ->checkbox();
                ?>
            </div>
            <div class="col-xs-4">
                <?php
                $icon = FA::icon('cog', ['ng-show' => 'in_progress', 'class' => 'wo-animate'])->spin();

                echo Html::submitButton($icon . ' ' . Yii::t('account', 'Sign In'), [
                    'class' => 'btn btn-primary btn-block btn-flat',
                    'ng-disabled' => 'in_progress',
                ]);
                ?>
            </div>
        </div>
        <?php
        \cookyii\widgets\angular\ActiveForm::end();

        $authAuthChoice = \yii\authclient\widgets\AuthChoice::begin([
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
        \yii\authclient\widgets\AuthChoice::end();

        ?>

        <a href="#">I forgot my password</a><br>
    </div>
</div>