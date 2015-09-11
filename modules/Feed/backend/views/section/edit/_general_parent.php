<?php
/**
 * _general_parent.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var cookyii\widgets\angular\ActiveForm $ActiveForm
 * @var cookyii\modules\Feed\backend\forms\SectionEditForm $SectionEditForm
 */

echo $ActiveForm->field($SectionEditForm, 'parent_id')
    ->dropdownList([], [
        'size' => 11,
        'ng-options' => 'section.id as section.label disable when section.disable for section in sections.list',
    ]);
