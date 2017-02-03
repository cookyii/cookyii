<?php
/**
 * index.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var Client\backend\forms\ClientEditForm $ClientEditForm
 */

use cookyii\modules\Client;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

$this->title = Yii::t('cookyii.client', 'Edit client');

Client\backend\assets\EditAssetBundle::register($this);

?>

<section <?= Html::renderTagAttributes([
    'class' => 'content',
    'ng-controller' => 'client.DetailController',
]) ?>>

    <div class="row" ng-show="clientUpdatedWarning">
        <div class="col-xs-12 col-lg-6">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><?= FA::icon('warning') ?></span>

                <div class="info-box-content">
                    <strong class="info-box-text"><?= Yii::t('cookyii', 'Warning') ?></strong>

                    <span class="progress-description">
                        <?= Yii::t('cookyii', 'The data of this item has been changed.') ?><br>
                        <?= Yii::t('cookyii', 'Recommended {refresh} the page.', [
                            'refresh' => Html::a(FA::icon('refresh') . ' ' . Yii::t('cookyii', 'Refresh'), null, [
                                'class' => 'btn btn-danger btn-xs',
                                'ng-click' => 'reload()',
                            ]),
                        ]) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
            <?php
            echo $this->render('_general', ['ClientEditForm' => $ClientEditForm]);
            ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5" ng-if="!isNewClient">
            <?php
            echo $this->render('_properties');
            ?>
        </div>
    </div>
</section>