<?php
/**
 * _general.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var cookyii\modules\Feed\backend\forms\SectionEditForm $SectionEditForm
 */

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var \cookyii\widgets\angular\ActiveForm $ActiveForm */
$ActiveForm = \cookyii\widgets\angular\ActiveForm::begin([
    'name' => 'SectionEditForm',
    'action' => $SectionEditForm->formAction(),
    'controller' => 'SectionEditController',
]);

?>

    <div class="box general">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('feed', 'General information') ?></h3>
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
                    <tabset>
                        <tab heading="Parent section" active="tabs.parent" select="selectTab('parent')">
                            <?php
                            echo $this->render('_general_parent', [
                                'ActiveForm' => $ActiveForm,
                                'SectionEditForm' => $SectionEditForm,
                            ]);
                            ?>
                        </tab>
                        <tab heading="Publishing" active="tabs.publishing" select="selectTab('publishing')">
                            <?php
                            echo $this->render('_general_publishing', [
                                'ActiveForm' => $ActiveForm,
                                'SectionEditForm' => $SectionEditForm,
                            ]);
                            ?>
                        </tab>
                        <tab heading="Meta" active="tabs.meta" select="selectTab('meta')">
                            <?php
                            echo $this->render('_general_meta', [
                                'ActiveForm' => $ActiveForm,
                                'SectionEditForm' => $SectionEditForm,
                            ]);
                            ?>
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
