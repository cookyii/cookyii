<?php
/**
 * _general_base.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var cookyii\widgets\angular\ActiveForm $ActiveForm
 * @var cookyii\modules\Feed\backend\forms\SectionEditForm $SectionEditForm
 */

echo $ActiveForm->field($SectionEditForm, 'title')
    ->textInput([
        'placeholder' => Yii::t('cookyii.feed', 'Some title...'),
    ]);

echo $ActiveForm->field($SectionEditForm, 'slug')
    ->textInput([
        'placeholder' => Yii::t('cookyii.feed', 'some-title'),
    ]);

echo $ActiveForm->field($SectionEditForm, 'sort')
    ->textInput([
        'placeholder' => '100',
    ]);