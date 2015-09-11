<?php
/**
 * _general_meta.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var cookyii\widgets\angular\ActiveForm $ActiveForm
 * @var cookyii\modules\Feed\backend\forms\SectionEditForm $SectionEditForm
 */

echo $ActiveForm->field($SectionEditForm, 'meta_title')
    ->textInput([
        'placeholder' => Yii::t('feed', 'Marketing title'),
    ]);

echo $ActiveForm->field($SectionEditForm, 'meta_keywords')
    ->textInput([
        'placeholder' => Yii::t('feed', 'keyword, password, handball'),
    ]);

echo $ActiveForm->field($SectionEditForm, 'meta_description')
    ->textarea([
        'msd-elastic' => true,
        'placeholder' => Yii::t('feed', 'A colorful description section'),
    ]);