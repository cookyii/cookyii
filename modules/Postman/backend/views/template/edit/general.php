<?php
/**
 * general.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 * @var Postman\backend\forms\TemplateEditForm $TemplateEditForm
 */

use cookyii\modules\Postman;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var \components\widgets\angular\ActiveForm $form */
$form = \components\widgets\angular\ActiveForm::begin([
    'name' => 'TemplateEditForm',
    'action' => $TemplateEditForm->formAction(),
    'controller' => 'TemplateEditController',
]);

?>

    <div class="box general">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('postman', 'General information') ?></h3>
        </div>

        <div class="box-notify">
            <?= Yii::t('cookyii', 'Changes not saved yet') ?>
            <?php
            echo Html::submitButton(FA::icon('check') . ' ' . Yii::t('page', 'Save'), [
                'class' => 'btn btn-slim btn-success',
                'ng-disabled' => 'in_progress',
            ]);
            ?>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 left-chunk">
                    <?php
                    echo $form->field($TemplateEditForm, 'code')
                        ->textInput();

                    echo $form->field($TemplateEditForm, 'subject')
                        ->textInput();

                    echo $form->field($TemplateEditForm, 'description')
                        ->textarea(['msd-elastic' => true]);

                    echo $form->field($TemplateEditForm, 'use_layout', [
                        'class' => \components\widgets\angular\material\ActiveField::className(),
                    ])
                        ->label(false)
                        ->checkbox();
                    ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8">
                    <tabset>
                        <tab heading="Content" active="tabs.content" select="selectTab('content')">
                            <div class="col-xs-12 col-sm-6 col-md-9">
                                <?php
                                echo $form->field($TemplateEditForm, 'content_text')
                                    ->textarea(['msd-elastic' => true]);

                                echo $form->field($TemplateEditForm, 'content_html')
                                    ->textarea(['msd-elastic' => true]);
                                ?>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3" style="padding-top: 20px;">
                                <dl>
                                    <dt ng-repeat-start="param in data.params track by param.key">
                                        {<span ng-bind="param.key"></span>}
                                    </dt>
                                    <dd ng-repeat-end ng-bind-html="param.description | nl2br"></dd>
                                </dl>
                            </div>
                        </tab>
                        <tab heading="Address" active="tabs.address" select="selectTab('address')">
                            <div class="address" ng-repeat="address in data.address">
                                <label>&nbsp;</label>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                        <select ng-model="address.type" class="form-control">
                                            <option>Select type</option>
                                            <option value="1">Reply to</option>
                                            <option value="2">To</option>
                                            <option value="3">Cc</option>
                                            <option value="4">Bcc</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                        <input type="text" ng-model="address.email" class="form-control">
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                        <input type="text" ng-model="address.name" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </tab>
                        <tab heading="Parameters" active="tabs.params" select="selectTab('params')">
                            <div class="param" ng-repeat="param in data.params track by param.key">
                                <label>&nbsp;</label>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                        <input type="text" ng-model="param.key" class="form-control">
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">
                                        <textarea ng-model="param.description" msd-elastic
                                                  class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </tab>
                    </tabset>
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
                'ng-click' => 'reload(TemplateEditForm)',
            ]);
            ?>
        </div>

        <div class="overlay" ng-if="inProgress">
            <?= FA::icon('cog')->spin() ?>
        </div>
    </div>

<?php

\components\widgets\angular\ActiveForm::end();
