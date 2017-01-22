<?php
/**
 * _general_publishing.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var cookyii\widgets\angular\ActiveForm $ActiveForm
 * @var cookyii\modules\Feed\backend\forms\ItemEditForm $ItemEditForm
 */

use cookyii\Decorator as D;

echo $ActiveForm->field($ItemEditForm, 'published_at')
    ->textInput([
        'ng-datetime-picker' => true,
        'placeholder' => D::Formatter()->asDatetime(time(), 'dd.MM.yyyy HH:mm'),
    ]);

echo $ActiveForm->field($ItemEditForm, 'archived_at')
    ->textInput([
        'ng-date-picker' => true,
        'ng-date-start' => 'data.published_at',
        'placeholder' => Yii::t('cookyii.feed', 'Never'),
    ]);