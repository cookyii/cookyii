<?php
/**
 * BlameableBehavior.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\behaviors;

/**
 * Class BlameableBehavior
 * @package cookyii\behaviors
 */
class BlameableBehavior extends \yii\behaviors\BlameableBehavior
{

    /**
     * @inheritdoc
     *
     * In case, when the [[value]] property is `null`, the value of `Yii::$app->user->id` will be used as the value.
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            switch (get_class(\Yii::$app)) {
                default:
                case \yii\console\Application::className():
                    $this->value = null;
                    break;
                case \yii\web\Application::className():
                    $this->value = !User()->isGuest ? User()->id : null;
                    break;
            }
        }

        if ($this->value instanceof \Closure || is_array($this->value) && is_callable($this->value)) {
            return call_user_func($this->value, $event);
        }

        return $this->value;
    }
}
