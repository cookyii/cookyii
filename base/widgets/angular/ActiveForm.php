<?php
/**
 * ActiveForm.php
 * @author Revin Roman
 */

namespace cookyii\widgets\angular;

use yii\helpers\Html;

/**
 * Class ActiveForm
 * @package cookyii\widgets\angular
 */
class ActiveForm extends \yii\widgets\ActiveForm
{

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
}