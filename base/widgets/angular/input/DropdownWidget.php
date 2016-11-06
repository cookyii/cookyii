<?php
/**
 * DropdownWidget.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\widgets\angular\input;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class DropdownWidget
 * @package cookyii\widgets\angular\input
 */
class DropdownWidget extends AbstractInputWidget
{

    /**
     * @var string
     */
    public $optionsScheme = 'key as value for (key, value) in %s';

    /**
     * @var array
     */
    public $items;

    /**
     * @var string
     */
    public $nullValue;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $options = $this->options;

        Html::addCssClass($options, 'form-control');

        $options['ng-options'] = sprintf($this->optionsScheme, Json::encode($this->items));
        $options['ng-model'] = ArrayHelper::remove($options, 'ng-model', sprintf('data.%s', $this->attribute));

        $items = [];
        if (!empty($this->nullValue)) {
            $items[''] = $this->nullValue;
        }

        if ($this->hasModel()) {
            echo Html::activeDropDownList($this->model, $this->attribute, $items, $options);
        } else {
            echo Html::dropDownList($this->name, null, $items, $options);
        }
    }
}
