<?php
/**
 * index.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 * @var Account\forms\AccountEditForm $AccountEditForm
 */

use backend\modules\Account;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

$this->title = $AccountEditForm->isNewAccount()
    ? Yii::t('account', 'Create new account')
    : Yii::t('account', 'Edit account');

Account\views\_assets\EditAssetBundle::register($this);

?>

    <section <?= Html::renderTagAttributes([
        'class' => 'content',
        'ng-controller' => 'AccountEditController',
    ]) ?>>

        <?php
        /** @var \common\widgets\angular\ActiveForm $form */
        $form = \common\widgets\angular\ActiveForm::begin([
            'name' => 'AccountEditForm',
            'action' => $AccountEditForm->formAction(),
        ]);
        ?>

        <div class="row" ng-show="userUpdatedWarning">
            <div class="col-xs-12 col-lg-6">
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><?= FA::icon('warning') ?></span>

                    <div class="info-box-content">
                        <strong class="info-box-text"><?= Yii::t('account', 'Warning') ?></strong>

                        <span class="progress-description">
                            <?= Yii::t('account', 'The data of this user has been changed.') ?><br>
                            <?= Yii::t('account', 'Recommended {refresh} the page.', [
                                'refresh' => Html::a(FA::icon('refresh') . ' ' . Yii::t('account', 'Refresh'), null, [
                                    'class' => 'btn btn-danger btn-xs',
                                    'ng-click' => 'reloadPage();',
                                ])
                            ]) ?>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
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
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="box properties">
                    <div class="box-header">
                        <h3 class="box-title"><?= Yii::t('account', 'Properties') ?></h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <ul class="list">
                                    <li ng-repeat="property in data.properties track by property.key">
                                        <a ng-click="editProperty(property)"
                                           ng-class="{active:editPropertyKey === property.key}">
                                            <span>{{ property.key }}</span> &ndash;
                                            {{ property.value }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 value">
                                <div class="form-group property-group has-feedback field-accounteditform-property"
                                     ng-repeat="property in data.properties track by property.key"
                                     ng-show="editPropertyKey === property.key">

                                    <input type="text" id="accounteditform-property"
                                           class="form-control" name="AccountEditForm[property]"
                                           title="Property" placeholder="Property" ng-model="property.key"
                                           tabindex="0"
                                           aria-invalid="false">

                                    <select class="form-control" ng-model="property.type">
                                        <?php
                                        echo Html::renderSelectOptions(false, \resources\User\Property::getAllTypes(), $options = [
                                            'prompt' => 'prompt',
                                        ]);
                                        ?>
                                    </select>

                                    <div ng-switch="property.type">
                                        <div ng-switch-when="<?= \resources\User\Property::TYPE_STRING ?>">
                                            <textarea class="form-control" ng-model="property.value_str"></textarea>
                                        </div>
                                        <div ng-switch-when="<?= \resources\User\Property::TYPE_INTEGER ?>">
                                            <input class="form-control" type="text" ng-model="property.value_int">
                                        </div>
                                        <div ng-switch-when="<?= \resources\User\Property::TYPE_FLOAT ?>">
                                            <input class="form-control" type="text" ng-model="property.value_float">
                                        </div>
                                        <div ng-switch-when="<?= \resources\User\Property::TYPE_TEXT ?>">
                                                <textarea class="form-control"
                                                          ng-model="property.value_text"></textarea>
                                        </div>
                                        <div ng-switch-when="<?= \resources\User\Property::TYPE_BLOB ?>">
                                            <input type="file">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="error-balloon ng-binding ng-hide" ng-show="error.properties[key]"
                                 aria-hidden="true"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <hr>

        <?php

        echo Html::submitButton(FA::icon('check') . ' ' . Yii::t('account', 'Save'), [
            'class' => 'btn btn-primary',
            'ng-disabled' => 'in_progress',
        ]);

        echo Html::resetButton(Yii::t('account', 'Cancek'), [
            'class' => 'btn btn-link'
        ]);

        \common\widgets\angular\ActiveForm::end();
        ?>

    </section>

<?php

/**
 * @param array $permissions
 * @param \common\widgets\angular\ActiveForm $form
 * @param Account\forms\AccountEditForm $AccountEditForm
 * @return string
 */
function renderPermissionLevel($permissions, $form, $AccountEditForm)
{
    ob_start();

    if (isset($permissions['items']) && !empty($permissions['items'])) {
        foreach ($permissions['items'] as $permission => $description) {
            echo $form->field($AccountEditForm, 'permissions[' . $permission . ']', [
                'class' => 'common\widgets\angular\material\ActiveField',
                'options' => ['class' => 'form-group narrow'],
            ])
                ->label(false)
                ->checkbox([
                    'class' => 'permissions checkbox-list',
                    'ng-model' => 'data.permissions["' . $permission . '"]',
                    'label' => $permission,
                    'title' => $description,
                ]);
        }
    }

    if (isset($permissions['children']) && !empty($permissions['children'])) {
        foreach ($permissions['children'] as $prefix => $conf) {
            $icon = Html::tag('i', null, [
                'class' => 'fa fa-fw',
                'ng-class' => sprintf('{"fa-chevron-down": rbacOpened["%1$s"],"fa-chevron-right": !rbacOpened["%1$s"]}', $prefix),
            ]);

            echo Html::tag('a', sprintf('%s %s', $icon, $prefix), [
                'ng-click' => sprintf('toggleRbacGroup("%s")', $prefix),
            ]);

            echo Html::tag('div', renderPermissionLevel($conf, $form, $AccountEditForm), [
                'ng-show' => sprintf('rbacOpened["%s"]', $prefix),
            ]);
        }
    }

    return Html::tag('div', ob_get_clean(), ['class' => 'level']);
}