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

Account\frontend\assets\SignInAssetBundle::register($this);

?>

<div class="box" ng-controller="Account.SignInController">
    <div class="box-logo">
        <?= Html::a(Html::tag('strong', APP_NAME), ['/']) ?>
    </div>

    <div class="box-body">
        <?php
        /** @var ActiveForm $form */
        $form = ActiveForm::begin([
            'model' => $SignInForm,
        ]);

        echo $form->field($SignInForm, 'email')
            ->textInput([
                'placeholder' => $SignInForm->getAttributeLabel('email'),
            ]);

        echo $form->field($SignInForm, 'password')
            ->passwordInput([
                'placeholder' => $SignInForm->getAttributeLabel('password'),
            ]);

        ?>
        <div class="row">
            <div class="col-xs-8">
                <?php
                echo $form->field($SignInForm, 'remember')
                    ->label(false)
                    ->checkbox([
                        'ng-icheck' => true,
                    ]);
                ?>
            </div>
            <div class="col-xs-4">
                <?php
                $icon = FA::icon('cog', ['ng-show' => 'in_progress', 'class' => 'wo-animate'])->spin();

                echo Html::submitButton($icon . ' ' . Yii::t('cookyii.account', 'Sign in'), [
                    'class' => 'btn btn-sm btn-primary btn-block btn-flat',
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

        <?= Html::a(Yii::t('cookyii.account', 'Sign up'), ['/account/sign/up']) ?><br>
        <?= Html::a(Yii::t('cookyii.account', 'I forgot my password'), ['/account/forgot-password']) ?>
    </div>
</div>