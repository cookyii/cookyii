<?php
/**
 * ActiveForm.php
 * @author Revin Roman
 */

namespace cookyii\widgets\angular\material;

/**
 * Class ActiveForm
 * @package cookyii\widgets\angular\material
 */
class ActiveForm extends \cookyii\widgets\angular\ActiveForm
{

    public $fieldClass = 'cookyii\widgets\angular\material\ActiveField';

    /**
     * Generates a form field.
     * A form field is associated with a model and an attribute. It contains a label, an input and an error message
     * and use them to interact with end users to collect their inputs for the attribute.
     * @param \yii\base\Model $model the data model
     * @param string $attribute the attribute name or expression. See [[Html::getAttributeName()]] for the format
     * about attribute expression.
     * @param array $options the additional configurations for the field object
     * @return \cookyii\widgets\angular\material\ActiveField the created ActiveField object
     * @see fieldConfig
     */
    public function field($model, $attribute, $options = [])
    {
        return parent::field($model, $attribute, $options);
    }
}