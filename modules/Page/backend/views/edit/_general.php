<?php
/**
 * _general.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 * @var Page\backend\forms\PageEditForm $PageEditForm
 */

use cookyii\modules\Page;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Json;

/** @var \components\widgets\angular\ActiveForm $form */
$form = \components\widgets\angular\ActiveForm::begin([
    'name' => 'PageEditForm',
    'action' => $PageEditForm->formAction(),
    'controller' => 'PageEditController',
]);

?>

    <div class="box general">
        <div class="box-header">
            <h3 class="box-title"><?= Yii::t('page', 'General information') ?></h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                    <?php
                    echo $form->field($PageEditForm, 'title')
                        ->textInput();

                    echo $form->field($PageEditForm, 'slug')
                        ->textInput();

                    ?>
                    <a ng-click="moreFields = true" ng-hide="moreFields">Show meta tags</a>

                    <div class="meta" ng-show="moreFields">
                        <?php

                        echo $form->field($PageEditForm, 'meta_title')
                            ->textInput();

                        echo $form->field($PageEditForm, 'meta_keywords')
                            ->textInput();

                        echo $form->field($PageEditForm, 'meta_description')
                            ->textarea(['msd-elastic' => true]);
                        ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-9">
                    <?php
                    echo $form->field($PageEditForm, 'content')
                        ->textarea([
                            'msd-elastic' => true,
                            'redactor' => true,
                        ]);
                    ?>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <?php
            echo Html::submitButton(FA::icon('check') . ' ' . Yii::t('page', 'Save'), [
                'class' => 'btn btn-success',
                'ng-disabled' => 'in_progress',
            ]);

            echo Html::button(Yii::t('page', 'Cancel'), [
                'class' => 'btn btn-link',
                'ng-click' => 'reload()',
            ]);
            ?>
        </div>

        <div class="overlay" ng-if="inProgress">
            <?= FA::icon('cog')->spin() ?>
        </div>
    </div>

<?php

\components\widgets\angular\ActiveForm::end();
