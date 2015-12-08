<?php
/**
 * _general_base.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var cookyii\widgets\angular\ActiveForm $ActiveForm
 * @var cookyii\modules\Page\backend\forms\PageEditForm $PageEditForm
 */

echo $ActiveForm->field($PageEditForm, 'title')
    ->textInput([
        'placeholder' => Yii::t('cookyii.page', 'Some title...'),
    ]);

echo $ActiveForm->field($PageEditForm, 'slug')
    ->textInput([
        'placeholder' => Yii::t('cookyii.page', 'some-title'),
    ]);