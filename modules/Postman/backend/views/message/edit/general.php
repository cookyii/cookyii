<?php
/**
 * general.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var Postman\backend\forms\MessageEditForm $MessageEditForm
 */

use cookyii\modules\Postman;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Json;

/** @var \cookyii\widgets\angular\ActiveForm $form */
$form = \cookyii\widgets\angular\ActiveForm::begin([
    'model' => $MessageEditForm,
    'controller' => 'MessageEditController',
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
                    echo $form->field($MessageEditForm, 'subject')
                        ->textInput([
                            'ng-model-options' => Json::encode(['debounce' => ['default' => 1000]]),
                        ]);

                    echo $form->field($MessageEditForm, 'scheduled_at')
                        ->textInput();

                    echo $form->field($MessageEditForm, 'error')
                        ->textarea(['msd-elastic' => true]);
                    ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8">
                    <tabset>
                        <tab heading="Content" active="tabs.content" select="selectTab('content')">
                            <div class="col-xs-12 col-sm-6 col-md-9">
                                <?php
                                echo $form->field($MessageEditForm, 'content_text')
                                    ->label('text/plain content')
                                    ->textarea([
                                        'ng-model-options' => Json::encode(['debounce' => ['default' => 1000]]),
                                        'msd-elastic' => true,
                                    ]);

                                echo $form->field($MessageEditForm, 'content_html')
                                    ->label('text/html content')
                                    ->textarea([
                                        'ng-model-options' => Json::encode(['debounce' => ['default' => 1000]]),
                                        'msd-elastic' => true,
                                    ]);
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
                            <div class="address" ng-repeat="address in data.address track by $index"
                                 ng-if="address !== undefined">
                                <label>&nbsp;</label>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                        <?= Html::dropDownList('address.type[{{ $index }}]', null, [], [
                                            'class' => 'form-control',
                                            'ng-model' => 'address.type',
                                            'ng-options' => 'type.id as type.label for type in address_types',
                                        ]) ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                        <?= Html::tag('input', null, [
                                            'type' => 'text',
                                            'name' => 'address[email][{{ $index }}]',
                                            'class' => 'form-control',
                                            'ng-model' => 'address.email',
                                            'placeholder' => Yii::t('postman', 'Email'),
                                        ]) ?>
                                    </div>
                                    <div class="col-xs-11 col-sm-5 col-md-5 col-lg-3">
                                        <?= Html::tag('input', null, [
                                            'type' => 'text',
                                            'name' => 'address.name[{{ $index }}]',
                                            'class' => 'form-control',
                                            'ng-model' => 'address.name',
                                            'placeholder' => Yii::t('postman', 'Name'),
                                        ]) ?>
                                    </div>
                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                        <a ng-click="removeAddress($index)" class="remove">
                                            <?= FA::icon('times') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="actions">
                                <?= Html::a(FA::icon('plus') . ' ' . Yii::t('postman', 'New address'), null, [
                                    'ng-click' => 'addAddress()',
                                ]) ?>
                            </div>
                        </tab>
                        <tab heading="Preview" active="tabs.preview" select="selectTab('preview')">
                            <label>text/plain preview</label>

                            <iframe ng-src="{{ previewUrl(data, 'text') }}" class="preview"></iframe>

                            <label>text/html preview</label>

                            <iframe ng-src="{{ previewUrl(data, 'html') }}" class="preview"></iframe>
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
                'ng-click' => 'reload(MessageEditForm)',
            ]);
            ?>
        </div>

        <div class="overlay" ng-if="inProgress">
            <?= FA::icon('cog')->spin() ?>
        </div>
    </div>

<?php

\cookyii\widgets\angular\ActiveForm::end();
