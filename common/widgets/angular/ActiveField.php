<?php
/**
 * ActiveField.php
 * @author Revin Roman
 */

namespace common\widgets\angular;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class ActiveField
 * @package common\widgets\angular
 */
class ActiveField extends \yii\widgets\ActiveField
{

    public $errorOptions = ['class' => 'error-balloon'];

    /**
     * @inheritdoc
     */
    public function render($content = null)
    {
        if ($content === null) {
            if (!isset($this->parts['{input}'])) {
                $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $this->inputOptions);
            }
            if (!isset($this->parts['{label}'])) {
                $this->parts['{label}'] = Html::activeLabel($this->model, $this->attribute, $this->labelOptions);
            }
            if (!isset($this->parts['{error}'])) {
                $this->parts['{error}'] = $this->_error($this->model, $this->attribute, $this->errorOptions);
            }
            if (!isset($this->parts['{hint}'])) {
                $this->parts['{hint}'] = '';
            }
            $content = strtr($this->template, $this->parts);
        } elseif (!is_string($content)) {
            $content = call_user_func($content, $this);
        }

        return $this->begin() . "\n" . $content . "\n" . $this->end();
    }

    /**
     * @return self
     */
    public function errorToLeft()
    {
        Html::addCssClass($this->errorOptions, 'left');

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function input($type, $options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', 'data.' . $this->attribute);

        return parent::input($type, $options);
    }

    /**
     * @inheritdoc
     */
    public function textInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', 'data.' . $this->attribute);

        return parent::textInput($options);
    }

    /**
     * @inheritdoc
     */
    public function passwordInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', 'data.' . $this->attribute);

        return parent::passwordInput($options);
    }

    /**
     * @inheritdoc
     */
    public function textarea($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', 'data.' . $this->attribute);

        return parent::textarea($options);
    }

    /**
     * Renders a email input.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     * @return static the field object itself
     */
    public function emailInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', 'data.' . $this->attribute);

        return static::input('email', $options);
    }

    /**
     * Renders a drop-down list.
     * The selection of the drop-down list is taken from the value of the model attribute.
     * @param array $items the option data items. The array keys are option values, and the array values
     * are the corresponding option labels. The array can also be nested (i.e. some array values are arrays too).
     * For each sub-array, an option group will be generated whose label is the key associated with the sub-array.
     * If you have a list of data models, you may convert them into the format described above using
     * [[ArrayHelper::map()]].
     *
     * Note, the values and labels will be automatically HTML-encoded by this method, and the blank spaces in
     * the labels will also be HTML-encoded.
     * @param array $options the tag options in terms of name-value pairs.
     *
     * For the list of available options please refer to the `$options` parameter of [[\yii\helpers\Html::activeDropDownList()]].
     *
     * If you set a custom `id` for the input element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @return static the field object itself
     */
    public function dropdownList($items, $options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', 'data.' . $this->attribute);

        return parent::dropdownList($items, $options);
    }

    /**
     * @inheritdoc
     */
    public function checkbox($options = [])
    {
        Html::addCssClass($this->options, 'checkbox');

        $options['iCheck'] = true;
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', 'data.' . $this->attribute);

        $options['label'] = $this->model->getAttributeLabel($this->attribute);

        $this->parts['{input}'] = Html::activeCheckbox($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function checkboxList($items, $options = [], $item_options = [])
    {
        $options['item'] = function ($index, $label, $name, $checked, $value) use ($item_options) {
            $options = [
                'value' => $value,
                'label' => $label,
                'iCheck' => true,
                'ng-model' => 'data.' . $this->attribute . '.' . $value,
            ];

            if (isset($item_options[$value])) {
                $options = array_merge($options, $item_options[$value]);
            }

            return Html::checkbox($name, $checked, $options);
        };

        return parent::checkboxList($items, $options);
    }

    /**
     * Generates a tag that contains the first validation error of the specified model attribute.
     * Note that even if there is no validation error, this method will still return an empty error tag.
     * @param \yii\base\Model $model the model object
     * @param string $attribute the attribute name or expression. See [[getAttributeName()]] for the format
     * about attribute expression.
     * @param array $options the tag options in terms of name-value pairs. The values will be HTML-encoded
     * using [[encode()]]. If a value is null, the corresponding attribute will not be rendered.
     *
     * The following options are specially handled:
     *
     * - tag: this specifies the tag name. If not set, "div" will be used.
     * - encode: boolean, if set to false then value won't be encoded.
     *
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     *
     * @return string the generated label tag
     */
    private function _error($model, $attribute, $options)
    {
        $attribute = Html::getAttributeName($attribute);
        $tag = isset($options['tag']) ? $options['tag'] : 'div';
        unset($options['tag']);
        $options['ng-show'] = 'error.' . $attribute;
        return Html::tag($tag, '{{ error.' . $attribute . ' }}', $options);
    }
}