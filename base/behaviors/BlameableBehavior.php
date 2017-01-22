<?php
/**
 * BlameableBehavior.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\behaviors;

use cookyii\Decorator as D;

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
            if (\Yii::$app instanceof \yii\web\Application) {
                $this->value = !D::User()->isGuest
                    ? D::User()->id
                    : null;
            } else {
                $this->value = null;
            }
        }

        if ($this->value instanceof \Closure || is_array($this->value) && is_callable($this->value)) {
            return call_user_func($this->value, $event);
        }

        return $this->value;
    }
}
