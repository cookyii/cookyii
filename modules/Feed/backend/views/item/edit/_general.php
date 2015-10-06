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
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var \cookyii\widgets\angular\ActiveForm $ActiveForm */
$ActiveForm = \cookyii\widgets\angular\ActiveForm::begin([
    'model' => $ItemEditForm,
    'controller' => 'ItemEditController',
]);

?>

    <div class="box general">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('feed', 'General information') ?></h3>
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
                    <tabset>
                        <tab heading="Content" active="tabs.content" select="selectTab('content')">
                            <?php
                            echo $this->render('_general_content', [
                                'ActiveForm' => $ActiveForm,
                                'ItemEditForm' => $ItemEditForm,
                            ]);
                            ?>
                        </tab>
                        <tab heading="Picture" active="tabs.picture" select="selectTab('picture')">
                            <?php
                            echo $this->render('_general_picture', [
                                'ActiveForm' => $ActiveForm,
                                'ItemEditForm' => $ItemEditForm,
                            ]);
                            ?>
                        </tab>
                        <tab heading="Section" active="tabs.sections" select="selectTab('sections')">
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
                        </tab>
                        <tab heading="Publishing" active="tabs.publishing" select="selectTab('publishing')">
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
                        </tab>
                        <tab heading="Meta" active="tabs.meta" select="selectTab('meta')">
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
                        </tab>
                    </tabset>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <?php
            echo Html::submitButton(FA::icon('check') . ' ' . Yii::t('feed', 'Save'), [
                'class' => 'btn btn-success',
                'ng-disabled' => 'in_progress',
            ]);

            echo Html::button(Yii::t('feed', 'Cancel'), [
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

\cookyii\widgets\angular\ActiveForm::end();
