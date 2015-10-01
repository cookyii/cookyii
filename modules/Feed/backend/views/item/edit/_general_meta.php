<?php
/**
 * _general_meta.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var cookyii\widgets\angular\ActiveForm $ActiveForm
 * @var cookyii\modules\Feed\backend\forms\ItemEditForm $ItemEditForm
 */

echo $ActiveForm->field($ItemEditForm, 'meta["title"]')
    ->label($ItemEditForm->getAttributeLabel('meta["title"]'))
    ->textInput([
        'placeholder' => Yii::t('feed', 'Marketing title'),
    ]);

echo $ActiveForm->field($ItemEditForm, 'meta["keywords"]')
    ->label($ItemEditForm->getAttributeLabel('meta["keywords"]'))
    ->textInput([
        'placeholder' => Yii::t('feed', 'keyword, password, handball'),
    ]);

echo $ActiveForm->field($ItemEditForm, 'meta["description"]')
    ->label($ItemEditForm->getAttributeLabel('meta["description"]'))
    ->textarea([
        'msd-elastic' => true,
        'placeholder' => Yii::t('feed', 'A colorful description section'),
    ]);