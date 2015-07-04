<?php
/**
 * _general_sections.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 *
 * @var yii\web\View $this
 * @var components\widgets\angular\ActiveForm $ActiveForm
 * @var cookyii\modules\Feed\backend\forms\ItemEditForm $ItemEditForm
 */

echo $ActiveForm->field($ItemEditForm, 'sections[]')
    ->dropdownList([], [
        'size' => 11,
        'multiple' => true,
        'ng-model' => 'data.sections',
        'ng-options' => 'section.id as section.label disable when section.disable for section in sections.list',
    ]);