<?php
/**
 * ActiveForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\widgets\angular;

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/**
 * Class ActiveForm
 * @package cookyii\widgets\angular
 */
class ActiveForm extends \yii\widgets\ActiveForm
{

    /** @var \cookyii\base\FormModel */
    public $model;

    /** @var string */
    public $name;

    /** @var string */
    public $controller;

    /** @inheritdoc */
    public $fieldClass = 'cookyii\widgets\angular\ActiveField';

    /** @inheritdoc */
    public $enableClientScript = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->model instanceof \cookyii\base\FormModel) {
            $this->name = empty($this->name) ? $this->model->getClass() : $this->name;
            $this->action = empty($this->action) ? $this->model->formAction() : $this->action;
        }

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->name;
        }

        if (!isset($this->options['ng-submit'])) {
            $this->options['ng-submit'] = sprintf('submit(%s, $event)', $this->name);
        }

        if (!empty($this->controller)) {
            $this->options['ng-controller'] = $this->controller;
        }

        $this->options['name'] = $this->name;
        $this->options['novalidate'] = true;

        echo Html::beginForm($this->action, $this->method, $this->options);
    }

    /**
     * Generates a form field.
     * A form field is associated with a model and an attribute. It contains a label, an input and an error message
     * and use them to interact with end users to collect their inputs for the attribute.
     * @param \yii\base\Model $model the data model
     * @param string $attribute the attribute name or expression. See [[Html::getAttributeName()]] for the format
     * about attribute expression.
     * @param array $options the additional configurations for the field object
     * @return \cookyii\widgets\angular\ActiveField the created ActiveField object
     * @see fieldConfig
     */
    public function field($model, $attribute, $options = [])
    {
        return parent::field($model, $attribute, $options);
    }

    /**
     * @param string $icon
     * @return string
     */
    public static function submitIcon($icon)
    {
        $result = (string)FA::icon('circle-o-notch', ['ng-show' => 'inProgress', 'class' => 'wo-animate'])->fixedWidth()->spin();
        $result .= (string)FA::icon($icon, ['ng-hide' => 'inProgress', 'class' => 'wo-animate'])->fixedWidth();

        return $result;
    }

    /**
     * @param string|null $icon
     * @param string $label
     * @param array $options
     * @return string
     */
    public static function submitButton($icon, $label, $options = [])
    {
        $icon = empty($icon) ? null : static::submitIcon($icon);
        $label = trim(sprintf('%s %s', $icon, $label));

        if (!isset($options['ng-disabled'])) {
            $options['ng-disabled'] = 'inProgress';
        }

        if (!isset($options['class'])) {
            $options['class'] = 'btn btn-success';
        }

        return Html::submitButton($label, $options);
    }

    /**
     * @param null|string $label
     * @param array $options
     * @return string
     */
    public static function resetButton($label = null, $options = [])
    {
        $label = empty($label) ? \Yii::t('cookyii', 'Cancel') : $label;

        if (!isset($options['ng-click'])) {
            $options['ng-click'] = 'reset($event)';
        }

        if (!isset($options['ng-disabled'])) {
            $options['ng-disabled'] = 'inProgress';
        }

        if (!isset($options['class'])) {
            $options['class'] = 'btn btn-link';
        }

        return Html::button($label, $options);
    }
}