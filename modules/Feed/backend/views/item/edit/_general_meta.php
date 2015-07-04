<?php
/**
 * _general_meta.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 *
 * @var yii\web\View $this
 * @var components\widgets\angular\ActiveForm $ActiveForm
 * @var cookyii\modules\Feed\backend\forms\ItemEditForm $ItemEditForm
 */

echo $ActiveForm->field($ItemEditForm, 'meta_title')
    ->textInput([
        'placeholder' => Yii::t('feed', 'Marketing title'),
    ]);

echo $ActiveForm->field($ItemEditForm, 'meta_keywords')
    ->textInput([
        'placeholder' => Yii::t('feed', 'keyword, password, handball'),
    ]);

echo $ActiveForm->field($ItemEditForm, 'meta_description')
    ->textarea([
        'msd-elastic' => true,
        'placeholder' => Yii::t('feed', 'A colorful description section'),
    ]);