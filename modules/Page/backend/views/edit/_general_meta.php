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
        echo $ActiveForm->field($PageEditForm, 'meta["title"]')
            ->label($PageEditForm->getAttributeLabel('meta["title"]'))
            ->textInput([
                'placeholder' => Yii::t('cookyii.page', 'Marketing title'),
            ]);

        echo $ActiveForm->field($PageEditForm, 'meta["keywords"]')
            ->label($PageEditForm->getAttributeLabel('meta["keywords"]'))
            ->textInput([
                'placeholder' => Yii::t('cookyii.page', 'keyword, password, handball'),
            ]);

        echo $ActiveForm->field($PageEditForm, 'meta["description"]')
            ->label($PageEditForm->getAttributeLabel('meta["description"]'))
            ->textarea([
                'msd-elastic' => true,
                'placeholder' => Yii::t('cookyii.page', 'A colorful description section'),
            ]);
        ?>
    </div>
</div>