<?php
/**
 * ButtonGroupInputWidget.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\widgets\angular\input;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class ButtonGroupInputWidget
 * @package cookyii\widgets\angular\input
 */
class ButtonGroupInputWidget extends AbstractInputWidget
{

    /** @var array */
    public $items;

    /** @var string radio or checkbox */
    public $type = self::TYPE_RADIO;

    /** @var array */
    public $itemOptions = ['class' => 'btn btn-default'];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $items = [];

        if (!empty($this->items)) {
            foreach ($this->items as $key => $label) {
                $options = $this->itemOptions;

                switch ($this->type) {
                    case static::TYPE_RADIO:
                        $options['btn-radio'] = Json::encode($key);
                        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));
                        break;
                    case static::TYPE_CHECKBOX:
                        $options['btn-checkbox'] = true;
                        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s["%s"]', $this->attribute, $key));
                        break;
                }

                $items[] = Html::tag('label', $label, $options);
            }
        }

        $options = $this->options;
        Html::addCssClass($options, 'btn-group');

        echo Html::tag('div', implode('', $items), $options);
    }

    const TYPE_RADIO = 'radio';
    const TYPE_CHECKBOX = 'checkbox';
}