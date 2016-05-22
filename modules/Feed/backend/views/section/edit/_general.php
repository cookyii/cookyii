<?php
/**
 * _general.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var cookyii\modules\Feed\backend\forms\SectionEditForm $SectionEditForm
 */

use cookyii\widgets\angular\ActiveForm;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var ActiveForm $ActiveForm */
$ActiveForm = ActiveForm::begin([
    'model' => $SectionEditForm,
    'controller' => 'feed.section.EditController',
]);

?>

    <div class="box general">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('cookyii.feed', 'General information') ?></h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-sm-6 left-chunk">
                    <?php
                    echo $this->render('_general_base', [
                        'ActiveForm' => $ActiveForm,
                        'SectionEditForm' => $SectionEditForm,
                    ]);
                    ?>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <uib-tabset active="tab.selected">
                        <uib-tab heading="Parent section">
                            <?php
                            echo $this->render('_general_parent', [
                                'ActiveForm' => $ActiveForm,
                                'SectionEditForm' => $SectionEditForm,
                            ]);
                            ?>
                        </uib-tab>
                        <uib-tab heading="Publishing">
                            <?php
                            echo $this->render('_general_publishing', [
                                'ActiveForm' => $ActiveForm,
                                'SectionEditForm' => $SectionEditForm,
                            ]);
                            ?>
                        </uib-tab>
                        <uib-tab heading="Meta">
                            <?php
                            echo $this->render('_general_meta', [
                                'ActiveForm' => $ActiveForm,
                                'SectionEditForm' => $SectionEditForm,
                            ]);
                            ?>
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
