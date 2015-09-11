<?php
/**
 * _general_content.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var cookyii\widgets\angular\ActiveForm $ActiveForm
 * @var cookyii\modules\Feed\backend\forms\ItemEditForm $ItemEditForm
 */

echo $ActiveForm->field($ItemEditForm, 'content_preview')
    ->textarea([
        'msd-elastic' => true,
        'redactor' => true,
    ]);

echo $ActiveForm->field($ItemEditForm, 'content_detail')
    ->textarea([
        'msd-elastic' => true,
        'redactor' => true,
    ]);