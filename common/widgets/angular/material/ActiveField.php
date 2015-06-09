<?php
/**
 * ActiveField.php
 * @author Revin Roman
 */

namespace common\widgets\angular\material;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class ActiveField
 * @package common\widgets\angular\material
 */
class ActiveField extends \yii\widgets\ActiveField
{

    /**
     * @inheritdoc
     */
    public $options = [];

    /**
     * @inheritdoc
     */
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
     * @inheritdoc
     */
    public function input($type, $options = [])
    {
        $this->options['tag'] = 'md-input-container';

        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', 'data.' . $this->attribute);

        return parent::input($type, $options);
    }

    /**
     * @inheritdoc
     */
    public function textInput($options = [])
    {
        $this->options['tag'] = 'md-input-container';

        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', 'data.' . $this->attribute);

        return parent::textInput($options);
    }

    /**
     * @inheritdoc
     */
    public function passwordInput($options = [])
    {
        $this->options['tag'] = 'md-input-container';

        $options['title'] = $options['placeholder'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', 'data.' . $this->attribute);

        return parent::passwordInput($options);
    }

    /**
     * @inheritdoc
     */
    public function textarea($options = [])
    {
        $this->options['tag'] = 'md-input-container';

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

        return Html::tag('md-input-container', parent::input('email', $options));
    }

    /**
     * @inheritdoc
     */
    public function dropdownList($items, $options = [])
    {
        Html::addCssClass($this->options, 'dropdownList');

        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', 'data.' . $this->attribute);

        return parent::dropDownList($items, $options);
    }

    /**
     * @inheritdoc
     */
    public function checkbox($options = [])
    {
        Html::addCssClass($this->options, 'checkbox');

        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', 'data.' . $this->attribute);

        $this->parts['{input}'] = Html::tag('md-checkbox', $this->model->getAttributeLabel($this->attribute), $options);

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
                'ng-model' => 'data.' . $this->attribute . '.' . $value,
            ];

            if (isset($item_options[$value])) {
                $options = array_merge($options, $item_options[$value]);
            }

            return Html::tag('md-checkbox', $label, $options);
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
        return Html::tag($tag, Html::tag('div', '{{ error.' . $attribute . ' }}'), $options);
    }
}