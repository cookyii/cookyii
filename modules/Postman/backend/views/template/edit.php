<?php
/**
 * index.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 * @var Postman\backend\forms\TemplateEditForm $TemplateEditForm
 */

use cookyii\modules\Postman;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

$this->title = Yii::t('postman', 'Edit template');

Postman\backend\_assets\TemplateEditAssetBundle::register($this);

?>

<section <?= Html::renderTagAttributes([
    'class' => 'content',
    'ng-controller' => 'TemplateDetailController',
]) ?>>

    <div class="row" ng-show="templateUpdatedWarning">
        <div class="col-xs-12 col-lg-6">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><?= FA::icon('warning') ?></span>

                <div class="info-box-content">
                    <strong class="info-box-text"><?= Yii::t('cookyii', 'Warning') ?></strong>

                    <span class="progress-description">
                        <?= Yii::t('cookyii', 'The data of this template has been changed.') ?><br>
                        <?= Yii::t('cookyii', 'Recommended {refresh} the page.', [
                            'refresh' => Html::a(FA::icon('refresh') . ' ' . Yii::t('cookyii', 'Refresh'), null, [
                                'class' => 'btn btn-danger btn-xs',
                                'ng-click' => 'reload()',
                            ])
                        ]) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            echo $this->render('edit/general', ['TemplateEditForm' => $TemplateEditForm]);
            ?>
        </div>
    </div>
</section>