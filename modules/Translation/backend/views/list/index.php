<?php
/**
 * index.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 */

use cookyii\modules\Translation;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Json;

$this->title = Yii::t('translation', 'Translations');

Translation\backend\assets\ListAssetBundle::register($this);

/**
 * @param string $type
 * @param string $label
 * @return string
 */
function sortLink($type, $label)
{
    $label .= ' ' . FA::icon('sort-numeric-desc', ['ng-show' => 'pages.sort.order === "-' . $type . '"']);
    $label .= ' ' . FA::icon('sort-numeric-asc', ['ng-show' => 'pages.sort.order === "' . $type . '"']);

    return Html::a($label, null, [
        'ng-click' => 'pages.sort.setOrder("' . $type . '")',
    ]);
}

?>

<section <?= Html::renderTagAttributes([
    'class' => 'content',
    'ng-controller' => 'TranslationListController',
]) ?>>
    <div class="row">
        <div class="col-xs-3 com-sm-3 col-md-3 col-lg-2">
            <div class="box-filter">
                <h3><?= Yii::t('translation', 'Filter') ?></h3>

                <hr>

                <?= Html::tag('a', FA::icon('check') . ' ' . Yii::t('translation', 'Translated'), [
                    'class' => 'checker',
                    'ng-click' => 'filter.toggleTranslated()',
                    'ng-class' => Json::encode(['checked' => new \yii\web\JsExpression('filter.translated === true')]),
                ]) ?>

                <br>

                <strong><?= Yii::t('translation', 'Context') ?>:</strong>
                <ul class="categories">
                    <li ng-repeat="(category, list) in phrases track by category">
                        <a ng-click="filter.setCategory(category)"
                           ng-class="{active: filter.selectedCategory === category}"
                           ng-bind="category"></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-xs-9 com-sm-9 col-md-9 col-lg-10">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= Yii::t('translation', 'Translations list') ?></h3>
                </div>

                <div class="box-body no-padding">
                    <div ng-show="phrases.length === 0" class="text-center text-italic text-light">
                        <?= Yii::t('translation', 'Phrases not found') ?>
                    </div>

                    <div class="table-responsive"
                         ng-repeat="(category, list) in phrases track by category"
                         ng-if="category === filter.selectedCategory">
                        <table class="table table-hover table-phrases">
                            <thead>
                            <tr>
                                <td ng-bind="category" class="category"></td>
                                <td ng-repeat="lang in languages track by lang"
                                    ng-bind="lang"
                                    class="lang"></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="(phrase, variants) in list">
                                <td>
                                    <p class="form-control-static" ng-bind="phrase"></p>
                                </td>
                                <td ng-repeat="lang in languages track by lang"
                                    class="lang">
                                    <textarea ng-model="variants[lang]"
                                              ng-blur="save(category, phrase, variants)"
                                              class="form-control"
                                              msd-elastic></textarea>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>