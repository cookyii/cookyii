<?php
/**
 * index.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 * @var Feed\backend\forms\SectionEditForm $SectionEditForm
 */

use cookyii\modules\Feed;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

$this->title = Yii::t('feed', 'Edit section');

Feed\backend\assets\EditSectionAssetBundle::register($this);

?>

<section <?= Html::renderTagAttributes([
    'class' => 'content',
    'ng-controller' => 'SectionDetailController',
]) ?>>

    <div class="row" ng-show="sectionUpdatedWarning">
        <div class="col-xs-12 col-lg-6">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><?= FA::icon('warning') ?></span>

                <div class="info-box-content">
                    <strong class="info-box-text"><?= Yii::t('cookyii', 'Warning') ?></strong>

                    <span class="progress-description">
                        <?= Yii::t('cookyii', 'The data of this section has been changed.') ?><br>
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
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8">
            <?php
            echo $this->render('_general', ['SectionEditForm' => $SectionEditForm]);
            ?>
        </div>
    </div>
</section>