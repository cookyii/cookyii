<?php
/**
 * ActiveField.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\widgets\angular;

use rmrevin\yii\fontawesome\FA;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Class ActiveField
 * @package cookyii\widgets\angular
 */
class ActiveField extends \yii\widgets\ActiveField
{

    public $template = "{label}\n{error}\n{input}\n{icon}\n{hint}";

    public $options = ['class' => 'form-group has-feedback'];

    public $errorOptions = ['class' => 'error-balloon', 'tag' => 'span'];

    const EVENT_BEFORE_RENDER_INPUT = 'beforeRenderInput';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!isset($this->options['ng-class'])) {
            $this->options['ng-class'] = Json::encode([
                'has-error' => new JsExpression(sprintf('error.%s', str_replace('[]', '', $this->attribute))),
            ]);
        }
    }

    private function setInlineTemplate()
    {
        $this->template = "{label}\n{input}\n{icon}\n{hint}\n{error}";

        $this->errorOptions['tag'] = 'div';
    }

    /**
     * @inheritdoc
     */
    public function render($content = null)
    {
        if ($content === null) {
            if (!isset($this->parts['{input}'])) {
                $this->textInput();
            }
            if (!isset($this->parts['{label}'])) {
                $this->label();
            }
            if (!isset($this->parts['{error}'])) {
                $this->parts['{error}'] = $this->_error($this->model, $this->attribute, $this->errorOptions);
            }
            if (!isset($this->parts['{icon}'])) {
                $this->parts['{icon}'] = '';
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
     * @param string $icon
     * @return static
     */
    public function icon($icon)
    {
        $icon = preg_match('|^\w+$|', $icon)
            ? (string)FA::icon($icon, ['class' => 'form-control-feedback'])
            : $icon;

        if (!preg_match('|form-control-feedback|', $icon)) {
            \Yii::warning(\Yii::t('cookyii', 'Icon must contain css class `{class}` ({icon})', [
                'icon' => $icon,
                'class' => 'form-control-feedback',
            ]));
        }

        $this->parts['{icon}'] = $icon;

        return $this;
    }

    /**
     * @param string $method
     * @param null|array $options
     */
    public function beforeRenderInput($method, &$options = null)
    {
        $event = new \cookyii\base\RenderEvent([
            'class' => get_called_class(),
            'method' => $method,
            'options' => $options,
        ]);

        $this->trigger(self::EVENT_BEFORE_RENDER_INPUT, $event);

        $options = $event->options;
    }

    /**
     * @inheritdoc
     */
    public function input($type, $options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return parent::input($type, $options);
    }

    /**
     * @inheritdoc
     */
    public function hiddenInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return parent::hiddenInput($options);
    }

    /**
     * @inheritdoc
     */
    public function textInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return parent::textInput($options);
    }

    /**
     * @inheritdoc
     */
    public function fileInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return parent::fileInput($options);
    }

    /**
     * @inheritdoc
     */
    public function passwordInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return parent::passwordInput($options);
    }

    /**
     * @inheritdoc
     */
    public function textarea($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

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
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return static::input('email', $options);
    }

    /**
     * Renders a color input.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     * @return static the field object itself
     */
    public function colorInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return static::input('color', $options);
    }

    /**
     * Renders a date input.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     * @return static the field object itself
     */
    public function dateInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return static::input('date', $options);
    }

    /**
     * Renders a datetime input.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     * @return static the field object itself
     */
    public function datetimeInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return static::input('datetime', $options);
    }

    /**
     * Renders a time input.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     * @return static the field object itself
     */
    public function timeInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return static::input('time', $options);
    }

    /**
     * Renders a local datetime input.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     * @return static the field object itself
     */
    public function datetimeLocalInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return static::input('datetime-local', $options);
    }

    /**
     * Renders a month input.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     * @return static the field object itself
     */
    public function monthInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return static::input('month', $options);
    }

    /**
     * Renders a number input.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     * @return static the field object itself
     */
    public function numberInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return static::input('number', $options);
    }

    /**
     * Renders a range input.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     * @return static the field object itself
     */
    public function rangeInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return static::input('range', $options);
    }

    /**
     * Renders a search input.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     * @return static the field object itself
     */
    public function searchInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return static::input('search', $options);
    }

    /**
     * Renders a tel input.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     * @return static the field object itself
     */
    public function telInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return static::input('tel', $options);
    }

    /**
     * Renders a url input.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     * @return static the field object itself
     */
    public function urlInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return static::input('url', $options);
    }

    /**
     * Renders a week input.
     * This method will generate the "name" and "value" tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     * @return static the field object itself
     */
    public function weekInput($options = [])
    {
        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return static::input('week', $options);
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
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return parent::dropdownList($items, $options);
    }

    /**
     * @inheritdoc
     */
    public function checkbox($options = [], $enclosedByLabel = true)
    {
        $this->setInlineTemplate();

        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return parent::checkbox($options, $enclosedByLabel);
    }

    /**
     * @inheritdoc
     */
    public function radio($options = [], $enclosedByLabel = true)
    {
        $this->setInlineTemplate();

        $options['title'] = $this->model->getAttributeLabel($this->attribute);
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $this->beforeRenderInput(__METHOD__, $options);

        return parent::radio($options, $enclosedByLabel);
    }

    /**
     * @inheritdoc
     */
    public function checkboxList($items, $options = [], $item_options = [])
    {
        $this->setInlineTemplate();

        $options['item'] = ArrayHelper::remove(
            $options,
            'item',
            function ($index, $label, $name, $checked, $value) use ($item_options) {
                $options = [
                    'value' => $value,
                    'label' => Html::tag('span', $label),
                    'iCheck' => true,
                    'ng-model' => sprintf('data.%s["%s"]', $this->attribute, $value),
                ];

                if (isset($item_options[$value])) {
                    $options = array_merge($options, $item_options[$value]);
                }

                return Html::checkbox($name, $checked, $options);
            }
        );

        $this->beforeRenderInput(__METHOD__, $options);

        return parent::checkboxList($items, $options);
    }

    /**
     * @inheritdoc
     */
    public function radioList($items, $options = [], $item_options = [])
    {
        $this->setInlineTemplate();

        $options['item'] = ArrayHelper::remove(
            $options,
            'item',
            function ($index, $label, $name, $checked, $value) use ($item_options) {
                $options = [
                    'value' => $value,
                    'label' => Html::tag('span', $label),
                    'iCheck' => true,
                    'ng-model' => sprintf('data.%s', $this->attribute),
                ];

                if (isset($item_options[$value])) {
                    $options = array_merge($options, $item_options[$value]);
                }

                return Html::radio($name, $checked, $options);
            }
        );

        $this->beforeRenderInput(__METHOD__, $options);

        return parent::radioList($items, $options);
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