<?php
/**
 * index.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 * @var Account\forms\AccountEditForm $AccountEditForm
 */

use backend\modules\Account;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

$this->title = $AccountEditForm->isNewAccount()
    ? Yii::t('account', 'Create new account')
    : Yii::t('account', 'Edit account');

Account\views\_assets\EditAssetBundle::register($this);

?>

<section <?= Html::renderTagAttributes([
    'class' => 'content',
    'ng-controller' => 'AccountEditController',
]) ?>>

    <div class="row" ng-show="userUpdatedWarning">
        <div class="col-xs-12 col-lg-6">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><?= FA::icon('warning') ?></span>

                <div class="info-box-content">
                    <strong class="info-box-text"><?= Yii::t('account', 'Warning') ?></strong>

                    <span class="progress-description">
                        <?= Yii::t('account', 'The data of this user has been changed.') ?><br>
                        <?= Yii::t('account', 'Recommended {refresh} the page.', [
                            'refresh' => Html::a(FA::icon('refresh') . ' ' . Yii::t('account', 'Refresh'), null, [
                                'class' => 'btn btn-danger btn-xs',
                                'ng-click' => 'reload()',
                            ])
                        ]) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <?php
            echo $this->render('_general', ['AccountEditForm' => $AccountEditForm]);
            ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
            <?php
            echo $this->render('_rbac');
            ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
            <?php
            echo $this->render('_properties');
            ?>
        </div>
    </div>
</section>