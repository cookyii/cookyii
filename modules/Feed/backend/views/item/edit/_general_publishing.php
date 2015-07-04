<?php
/**
 * _general_publishing.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 *
 * @var yii\web\View $this
 * @var components\widgets\angular\ActiveForm $ActiveForm
 * @var cookyii\modules\Feed\backend\forms\ItemEditForm $ItemEditForm
 */

echo $ActiveForm->field($ItemEditForm, 'published_at')
    ->textInput([
        'ng-datetime-picker' => true,
        'placeholder' => Formatter()->asDatetime(time(), 'dd.MM.yyyy HH:mm'),
    ]);

echo $ActiveForm->field($ItemEditForm, 'archived_at')
    ->textInput([
        'ng-date-picker' => true,
        'ng-date-start' => 'data.published_at',
        'placeholder' => Formatter()->asDate(time() + (86400 * 180), 'dd.MM.yyyy'),
    ]);