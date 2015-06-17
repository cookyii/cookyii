<?php
/**
 * _general.php
 * @author Revin Roman http://phptime.ru
 *
 * @var yii\web\View $this
 * @var \common\widgets\angular\ActiveForm $form
 * @var Account\forms\AccountEditForm $AccountEditForm
 */

use backend\modules\Account;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

?>

<div class="box general">
    <div class="box-header">
        <h3 class="box-title"><?= Yii::t('account', 'General information') ?></h3>
    </div>

    <div class="box-body">
        <?php
        echo $form->field($AccountEditForm, 'name')
            ->label(false)
            ->textInput(['placeholder' => $AccountEditForm->getAttributeLabel('name')]);

        echo $form->field($AccountEditForm, 'email')
            ->label(false)
            ->textInput(['placeholder' => $AccountEditForm->getAttributeLabel('email')]);

        echo Html::tag('strong', Yii::t('account', 'Roles'));

        echo $form->field($AccountEditForm, 'roles', [
            'class' => 'common\widgets\angular\material\ActiveField',
            'options' => ['class' => 'form-group narrow'],
        ])
            ->label(false)
            ->checkboxList(
                Account\forms\AccountEditForm::getRoleValues(),
                ['class' => 'roles checkbox-list'],
                ['user' => ['disabled' => true]]
            );
        ?>
    </div>

    <div class="box-footer">
        <?php
        echo Html::submitButton(FA::icon('check') . ' ' . Yii::t('account', 'Save'), [
            'class' => 'btn btn-success',
            'ng-disabled' => 'in_progress',
        ]);

        echo Html::button(Yii::t('account', 'Cancel'), [
            'class' => 'btn btn-link',
            'ng-click' => 'reload()',
        ]);
        ?>
    </div>

    <div class="overlay" ng-if="inProgress">
        <?= FA::icon('cog')->spin() ?>
    </div>
</div>