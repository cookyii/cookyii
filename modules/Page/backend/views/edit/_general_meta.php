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

?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
        <?php
        echo $ActiveForm->field($PageEditForm, 'meta_title')
            ->textInput([
                'placeholder' => Yii::t('page', 'Marketing title'),
            ]);

        echo $ActiveForm->field($PageEditForm, 'meta_keywords')
            ->textInput([
                'placeholder' => Yii::t('page', 'keyword, password, handball'),
            ]);

        echo $ActiveForm->field($PageEditForm, 'meta_description')
            ->textarea([
                'msd-elastic' => true,
                'placeholder' => Yii::t('page', 'A colorful description section'),
            ]);
        ?>
    </div>
</div>