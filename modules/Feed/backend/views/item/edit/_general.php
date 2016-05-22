<?php
/**
 * _general.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var Feed\backend\forms\ItemEditForm $ItemEditForm
 */

use cookyii\modules\Feed;
use cookyii\widgets\angular\ActiveForm;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var ActiveForm $ActiveForm */
$ActiveForm = ActiveForm::begin([
    'model' => $ItemEditForm,
    'controller' => 'feed.item.EditController',
]);

?>

    <div class="box general">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('cookyii.feed', 'General information') ?></h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-4 left-chunk">
                    <?php
                    echo $this->render('_general_base', [
                        'ActiveForm' => $ActiveForm,
                        'ItemEditForm' => $ItemEditForm,
                    ]);
                    ?>
                </div>
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8">
                    <uib-tabset active="tab.selected">
                        <uib-tab heading="Content">
                            <?php
                            echo $this->render('_general_content', [
                                'ActiveForm' => $ActiveForm,
                                'ItemEditForm' => $ItemEditForm,
                            ]);
                            ?>
                        </uib-tab>
                        <uib-tab heading="Picture">
                            <?php
                            echo $this->render('_general_picture', [
                                'ActiveForm' => $ActiveForm,
                                'ItemEditForm' => $ItemEditForm,
                            ]);
                            ?>
                        </uib-tab>
                        <uib-tab heading="Section">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                                    <?php
                                    echo $this->render('_general_sections', [
                                        'ActiveForm' => $ActiveForm,
                                        'ItemEditForm' => $ItemEditForm,
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </uib-tab>
                        <uib-tab heading="Publishing">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                                    <?php
                                    echo $this->render('_general_publishing', [
                                        'ActiveForm' => $ActiveForm,
                                        'ItemEditForm' => $ItemEditForm,
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </uib-tab>
                        <uib-tab heading="Meta">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                                    <?php
                                    echo $this->render('_general_meta', [
                                        'ActiveForm' => $ActiveForm,
                                        'ItemEditForm' => $ItemEditForm,
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </uib-tab>
                    </uib-tabset>
                </div>
            </div>
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
