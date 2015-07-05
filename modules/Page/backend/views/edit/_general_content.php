<?php
/**
 * _general_base.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 *
 * @var yii\web\View $this
 * @var components\widgets\angular\ActiveForm $ActiveForm
 * @var cookyii\modules\Page\backend\forms\PageEditForm $PageEditForm
 */

echo $ActiveForm->field($PageEditForm, 'content')
    ->textarea([
        'msd-elastic' => true,
        'redactor' => true,
    ]);