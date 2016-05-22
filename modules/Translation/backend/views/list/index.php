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

$this->title = Yii::t('cookyii.translation', 'Translations');

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
    'ng-controller' => 'translation.ListController',
]) ?>>
    <div class="row">
        <div class="col-xs-3 com-sm-3 col-md-3 col-lg-2">
            <div class="box-filter">
                <h3><?= Yii::t('cookyii', 'Filter') ?></h3>

                <hr>

                <?= Html::tag('a', FA::icon('check') . ' ' . Yii::t('cookyii.translation', 'Translated'), [
                    'class' => 'checker',
                    'ng-click' => 'filter.toggleTranslated()',
                    'ng-class' => Json::encode(['checked' => new \yii\web\JsExpression('filter.translated === true')]),
                ]) ?>

                <br>

                <strong><?= Yii::t('cookyii.translation', 'Languages') ?>:</strong>
                <ul class="languages">
                    <li>
                        <a class="checker"
                           ng-click="filter.toggleLanguage()"
                           ng-class="{checked: filter.isAllLanguagesSelected()}"
                        ><?= FA::icon('check') ?> <?= Yii::t('cookyii.translation', 'All') ?></a>
                    </li>
                    <li ng-repeat="language in languages track by language">
                        <a class="checker"
                           ng-click="filter.toggleLanguage(language)"
                           ng-class="{checked: filter.isLanguageSelect(language)}"
                        ><?= FA::icon('check') ?> {{ language }}</a>
                    </li>
                </ul>

                <br>

                <strong><?= Yii::t('cookyii.translation', 'Context') ?>:</strong>
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
                    <h3 class="box-title"><?= Yii::t('cookyii.translation', 'Phrases') ?></h3>
                </div>

                <div class="box-body no-padding">
                    <div ng-show="phrases.length === 0" class="text-center text-italic text-light">
                        <?= Yii::t('cookyii.translation', 'Phrases not found') ?>
                    </div>

                    <div class="table-responsive"
                         ng-repeat="(category, list) in phrases track by category"
                         ng-if="category === filter.selectedCategory && !isFullTranslated()">
                        <table class="table table-hover table-phrases">
                            <thead>
                            <tr>
                                <td ng-bind="category" class="category"></td>
                                <td ng-repeat="language in languages track by language"
                                    ng-show="filter.isAllLanguagesSelected() || filter.isLanguageSelect(language)"
                                    ng-bind="language"
                                    class="lang"></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="(phrase, variants) in list"
                                ng-hide="!filter.translated && isFullTranslatedPhrase(phrase, variants)">
                                <td>
                                    <p class="form-control-static" ng-bind="phrase"></p>
                                </td>
                                <td ng-repeat="language in languages track by language"
                                    ng-show="filter.isAllLanguagesSelected() || filter.isLanguageSelect(language)"
                                    class="lang">
                                    <textarea ng-model="variants[language]"
                                              ng-focus="focus(phrase)"
                                              ng-blur="save($event, category, phrase, variants, language)"
                                              ng-class="saveResult(category, phrase, variants, language)"
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