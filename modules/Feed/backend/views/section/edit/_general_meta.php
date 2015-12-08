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

echo $ActiveForm->field($SectionEditForm, 'meta["title"]')
    ->label($SectionEditForm->getAttributeLabel('meta["title"]'))
    ->textInput([
        'placeholder' => Yii::t('cookyii.feed', 'Marketing title'),
    ]);

echo $ActiveForm->field($SectionEditForm, 'meta["keywords"]')
    ->label($SectionEditForm->getAttributeLabel('meta["keywords"]'))
    ->textInput([
        'placeholder' => Yii::t('cookyii.feed', 'keyword, password, handball'),
    ]);

echo $ActiveForm->field($SectionEditForm, 'meta["description"]')
    ->label($SectionEditForm->getAttributeLabel('meta["description"]'))
    ->textarea([
        'msd-elastic' => true,
        'placeholder' => Yii::t('cookyii.feed', 'A colorful description section'),
    ]);