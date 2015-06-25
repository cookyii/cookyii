<?php
/**
 * _general.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 * @var Feed\backend\forms\ItemEditForm $ItemEditForm
 */

use cookyii\modules\Feed;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var \components\widgets\angular\ActiveForm $form */
$form = \components\widgets\angular\ActiveForm::begin([
    'name' => 'ItemEditForm',
    'action' => $ItemEditForm->formAction(),
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
                    echo $form->field($ItemEditForm, 'title')
                        ->textInput([
                            'placeholder' => Yii::t('feed', 'Some title...'),
                        ]);

                    echo $form->field($ItemEditForm, 'slug')
                        ->textInput([
                            'placeholder' => Yii::t('feed', 'some-title'),
                        ]);

                    echo $form->field($ItemEditForm, 'sort')
                        ->textInput([
                            'placeholder' => '100',
                        ]);
                    ?>
                </div>
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8">
                    <tabset>
                        <tab heading="Content" active="tabs.content" select="selectTab('content')">
                            <?php
                            echo $form->field($ItemEditForm, 'content_preview')
                                ->textarea([
                                    'msd-elastic' => true,
                                    'redactor' => true,
                                ]);

                            echo $form->field($ItemEditForm, 'content_detail')
                                ->textarea([
                                    'msd-elastic' => true,
                                    'redactor' => true,
                                ]);
                            ?>
                        </tab>
                        <tab heading="Section" active="tabs.sections" select="selectTab('sections')">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                                    <?php
                                    list($items, $options) = $ItemEditForm->getSectionValues();

                                    echo $form->field($ItemEditForm, 'sections[]')
                                        ->dropdownList($items, [
                                            'size' => 11,
                                            'multiple' => true,
                                            'options' => $options,
                                            'ng-model' => 'data.sections',
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </tab>
                        <tab heading="Publishing" active="tabs.publishing" select="selectTab('publishing')">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                                    <?php
                                    echo $form->field($ItemEditForm, 'published_at')
                                        ->textInput([
                                            'ng-datetime-picker' => true,
                                            'placeholder' => Formatter()->asDatetime(time(), 'dd.MM.yyyy HH:mm'),
                                        ]);

                                    echo $form->field($ItemEditForm, 'archived_at')
                                        ->textInput([
                                            'ng-date-picker' => true,
                                            'ng-date-start' => 'data.published_at',
                                            'placeholder' => Formatter()->asDate(time() + (86400 * 180), 'dd.MM.yyyy'),
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </tab>
                        <tab heading="Meta" active="tabs.meta" select="selectTab('meta')">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                                    <?php

                                    echo $form->field($ItemEditForm, 'meta_title')
                                        ->textInput([
                                            'placeholder' => Yii::t('feed', 'Marketing title'),
                                        ]);

                                    echo $form->field($ItemEditForm, 'meta_keywords')
                                        ->textInput([
                                            'placeholder' => Yii::t('feed', 'keyword, password, handball'),
                                        ]);

                                    echo $form->field($ItemEditForm, 'meta_description')
                                        ->textarea([
                                            'msd-elastic' => true,
                                            'placeholder' => Yii::t('feed', 'A colorful description section'),
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

\components\widgets\angular\ActiveForm::end();
