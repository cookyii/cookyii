<?php
/**
 * _general_base.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 *
 * @var yii\web\View $this
 * @var cookyii\widgets\angular\ActiveForm $ActiveForm
 * @var cookyii\modules\Feed\backend\forms\ItemEditForm $ItemEditForm
 */

echo $ActiveForm->field($ItemEditForm, 'title')
    ->textInput([
        'placeholder' => Yii::t('feed', 'Some title...'),
    ]);

echo $ActiveForm->field($ItemEditForm, 'slug')
    ->textInput([
        'placeholder' => Yii::t('feed', 'some-title'),
    ]);

echo $ActiveForm->field($ItemEditForm, 'sort')
    ->textInput([
        'placeholder' => '100',
    ]);