<?php
/**
 * _general.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 * @var Page\backend\forms\PageEditForm $PageEditForm
 */

use cookyii\modules\Page;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var \components\widgets\angular\ActiveForm $form */
$form = \components\widgets\angular\ActiveForm::begin([
    'name' => 'PageEditForm',
    'action' => $PageEditForm->formAction(),
    'controller' => 'PageEditController',
]);

?>

    <div class="box general">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('page', 'General information') ?></h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-4 left-chunk">
                    <?php
                    echo $form->field($PageEditForm, 'title')
                        ->textInput([
                            'placeholder' => Yii::t('feed', 'Some title...'),
                        ]);

                    echo $form->field($PageEditForm, 'slug')
                        ->textInput([
                            'placeholder' => Yii::t('feed', 'some-title'),
                        ]);
                    ?>
                </div>
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8">
                    <tabset>
                        <tab heading="Content" active="tabs.content" select="selectTab('content')">
                            <?php
                            echo $form->field($PageEditForm, 'content')
                                ->textarea([
                                    'msd-elastic' => true,
                                    'redactor' => true,
                                ]);
                            ?>
                        </tab>
                        <tab heading="Meta" active="tabs.meta" select="selectTab('meta')">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                                    <?php

                                    echo $form->field($PageEditForm, 'meta_title')
                                        ->textInput([
                                            'placeholder' => Yii::t('feed', 'Marketing title'),
                                        ]);

                                    echo $form->field($PageEditForm, 'meta_keywords')
                                        ->textInput([
                                            'placeholder' => Yii::t('feed', 'keyword, password, handball'),
                                        ]);

                                    echo $form->field($PageEditForm, 'meta_description')
                                        ->textarea([
                                            'msd-elastic' => true,
                                            'placeholder' => Yii::t('feed', 'A colorful description section'),
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </tab>
                    </tabset>
                    <?php

                    ?>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <?php
            echo Html::submitButton(FA::icon('check') . ' ' . Yii::t('page', 'Save'), [
                'class' => 'btn btn-success',
                'ng-disabled' => 'in_progress',
            ]);

            echo Html::button(Yii::t('page', 'Cancel'), [
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
