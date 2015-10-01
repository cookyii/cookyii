<?php
/**
 * index.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var Account\backend\forms\AccountEditForm $AccountEditForm
 */

use cookyii\modules\Account;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

$this->title = Yii::t('account', 'Edit account');

Account\backend\assets\EditAssetBundle::register($this);

?>

<section <?= Html::renderTagAttributes([
    'class' => 'content',
    'ng-controller' => 'AccountDetailController',
]) ?>>

    <div class="row" ng-show="accountUpdatedWarning">
        <div class="col-xs-12 col-lg-6">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><?= FA::icon('warning') ?></span>

                <div class="info-box-content">
                    <strong class="info-box-text"><?= Yii::t('cookyii', 'Warning') ?></strong>

                    <span class="progress-description">
                        <?= Yii::t('cookyii', 'The data of this account has been changed.') ?><br>
                        <?= Yii::t('cookyii', 'Recommended {refresh} the page.', [
                            'refresh' => Html::a(FA::icon('refresh') . ' ' . Yii::t('cookyii', 'Refresh'), null, [
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
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3" ng-if="!isNewAccount">
            <?php
            echo $this->render('_rbac', ['AccountEditForm' => $AccountEditForm]);
            ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5" ng-if="!isNewAccount">
            <?php
            echo $this->render('_properties');
            ?>
        </div>
    </div>
</section>