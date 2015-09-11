<?php
/**
 * _general.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var Page\backend\forms\PageEditForm $PageEditForm
 */

use cookyii\modules\Page;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/** @var \cookyii\widgets\angular\ActiveForm $ActiveForm */
$ActiveForm = \cookyii\widgets\angular\ActiveForm::begin([
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
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-4 left-chunk">
                    <?php
                    echo $this->render('_general_base', [
                        'ActiveForm' => $ActiveForm,
                        'PageEditForm' => $PageEditForm,
                    ]);
                    ?>
                </div>
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-8">
                    <tabset>
                        <tab heading="Content" active="tabs.content" select="selectTab('content')">
                            <?php
                            echo $this->render('_general_content', [
                                'ActiveForm' => $ActiveForm,
                                'PageEditForm' => $PageEditForm,
                            ]);
                            ?>
                        </tab>
                        <tab heading="Meta" active="tabs.meta" select="selectTab('meta')">
                            <?php
                            echo $this->render('_general_meta', [
                                'ActiveForm' => $ActiveForm,
                                'PageEditForm' => $PageEditForm,
                            ]);
                            ?>
                        </tab>
                    </tabset>
                    <?php

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

\cookyii\widgets\angular\ActiveForm::end();
