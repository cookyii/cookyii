<?php
/**
 * _general.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 * @var Feed\backend\forms\SectionEditForm $SectionEditForm
 */

use cookyii\modules\Feed;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var \components\widgets\angular\ActiveForm $form */
$form = \components\widgets\angular\ActiveForm::begin([
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
                    echo $form->field($SectionEditForm, 'title')
                        ->textInput([
                            'placeholder' => Yii::t('feed', 'Some title...'),
                        ]);

                    echo $form->field($SectionEditForm, 'slug')
                        ->textInput([
                            'placeholder' => Yii::t('feed', 'some-title'),
                        ]);

                    echo $form->field($SectionEditForm, 'sort')
                        ->textInput([
                            'placeholder' => '100',
                        ]);
                    ?>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <tabset>
                        <tab heading="Parent section" active="tabs.parent" select="selectTab('parent')">
                            <?php
                            list($items, $options) = $SectionEditForm->getParentValues();

                            echo $form->field($SectionEditForm, 'parent_id')
                                ->dropdownList($items, [
                                    'size' => 11,
                                    'options' => $options,
                                ]);
                            ?>
                        </tab>
                        <tab heading="Publishing" active="tabs.publishing" select="selectTab('publishing')">
                            <?php
                            echo $form->field($SectionEditForm, 'published_at')
                                ->textInput([
                                    'ng-datetime-picker' => true,
                                    'placeholder' => Formatter()->asDatetime(time(), 'dd.MM.yyyy HH:mm'),
                                ]);

                            echo $form->field($SectionEditForm, 'archived_at')
                                ->textInput([
                                    'ng-date-picker' => true,
                                    'ng-date-start' => 'data.published_at',
                                    'placeholder' => Formatter()->asDate(time() + (86400 * 180), 'dd.MM.yyyy'),
                                ]);
                            ?>
                        </tab>
                        <tab heading="Meta" active="tabs.meta" select="selectTab('meta')">
                            <?php

                            echo $form->field($SectionEditForm, 'meta_title')
                                ->textInput([
                                    'placeholder' => Yii::t('feed', 'Marketing title'),
                                ]);

                            echo $form->field($SectionEditForm, 'meta_keywords')
                                ->textInput([
                                    'placeholder' => Yii::t('feed', 'keyword, password, handball'),
                                ]);

                            echo $form->field($SectionEditForm, 'meta_description')
                                ->textarea([
                                    'msd-elastic' => true,
                                    'placeholder' => Yii::t('feed', 'A colorful description section'),
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

\components\widgets\angular\ActiveForm::end();
