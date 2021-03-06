<?php
/**
 * _properties.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 */

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

?>

<div class="box properties" ng-controller="client.edit.PropertiesController">
    <div class="box-header">
        <h3 class="box-title" style="padding-bottom: 0;">
            <?= Yii::t('cookyii.client', 'Properties') ?>

            <div class="input-group" style="display: inline-block; vertical-align: middle;">
                <?= Html::textInput(null, null, [
                    'class' => 'form-control properties-search input-sm',
                    'placeholder' => Yii::t('cookyii', 'Search'),
                    'maxlength' => 100,
                    'ng-model' => 'search',
                ]) ?>
                <a ng-click="search = undefined"
                   ng-show="search"
                   style="right: 10px;"
                   class="clear-search"
                   aria-hidden="false">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </h3>

        <div class="box-tools">
            <?= Html::button(FA::icon('plus'), [
                'class' => 'btn btn-slim btn-info pull-right',
                'ng-click' => 'create()',
                'title' => Yii::t('cookyii.client', 'Create new property'),
            ]) ?>
        </div>
    </div>

    <div class="box-body" style="padding-top: 0;">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <ul class="list">
                    <li class="placeholder">
                        <a class="active"
                           ng-if="editedProperty && isNewProperty">
                            <div class="key" ng-show="editedProperty.key">
                                {{ editedProperty.key }}
                            </div>

                            <div ng-hide="editedProperty.key">
                                New property
                            </div>

                            <div class="value" ng-show="editedProperty.value">
                                {{ editedProperty.value | truncateCharacters: 50 }}
                            </div>
                        </a>
                    </li>
                    <li ng-repeat="property in data.properties | filter:search as searchResults track by property.key"
                        ng-hide="$index > limit && !detailedList">
                        <a ng-click="edit(property)"
                           ng-class="{active:editedProperty.key === property.key}">
                            <div class="key">{{ property.key }}</div>

                            <div class="value" ng-show="property.value">
                                {{ property.value | truncateCharacters: 50 }}
                            </div>
                        </a>
                    </li>
                    <li class="more" ng-if="searchResults.length > limit && !detailedList">
                        <a ng-click="toggleAllProperties()">
                            <?= FA::icon('chevron-down') ?>
                            See all properies ({{ searchResults.length }})
                        </a>
                    </li>
                    <li class="more" ng-if="searchResults.length > limit && detailedList">
                        <a ng-click="toggleAllProperties()"><?= FA::icon('chevron-up') ?> Collapse</a>
                    </li>
                    <li class="empty" ng-if="searchResults.length === 0">
                        <?= Yii::t('cookyii.client', 'No properties.') ?>
                    </li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 value">
                <div class="form-group property-group has-feedback field-clienteditform-property"
                     ng-show="editedProperty !== null">

                    <div class="actions text-right">
                        <?= Html::button(Yii::t('cookyii.client', 'Delete'), [
                            'class' => 'btn btn-slim btn-link text-red',
                            'ng-click' => 'remove(editedProperty, $event)',
                            'ng-if' => '!isNewProperty',
                        ]) ?>
                        <?= Html::button(Yii::t('cookyii', 'Cancel'), [
                            'class' => 'btn btn-slim btn-link',
                            'ng-click' => 'cancel()',
                        ]) ?>
                        <?= Html::button(FA::icon('check') . ' ' . Yii::t('cookyii', 'Save'), [
                            'class' => 'btn btn-slim btn-success',
                            'ng-click' => 'save(editedProperty, false)',
                            'title' => Yii::t('cookyii.client', 'Save and edit property'),
                        ]) ?>
                        <?= Html::button(FA::icon('check') . ' ' . FA::icon('plus'), [
                            'class' => 'btn btn-slim btn-success',
                            'ng-click' => 'save(editedProperty, true)',
                            'ng-if' => 'isNewProperty',
                            'title' => Yii::t('cookyii.client', 'Save and create new property'),
                        ]) ?>
                    </div>

                    <input type="text" id="clienteditform-property"
                           class="form-control input-sm"
                           title="Property key" placeholder="Property key"
                           ng-model="editedProperty.key"
                           tabindex="0"
                           aria-invalid="false">

                    <textarea class="form-control input-sm"
                              placeholder="Property value"
                              ng-model="editedProperty.value"
                              msd-elastic></textarea>
                </div>
            </div>
        </div>
    </div>
</div>