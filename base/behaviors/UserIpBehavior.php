<?php
/**
 * UserIpBehavior.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\behaviors;

use cookyii\Decorator as D;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * Class UserIpBehavior
 * @package cookyii\behaviors
 */
class UserIpBehavior extends \yii\behaviors\AttributeBehavior
{

    /**
     * @var string the attribute that will receive user ip value
     */
    public $userIpAtAttribute = 'user_ip';

    /**
     * @var callable|\yii\db\Expression The expression that will be used for generating the id.
     * This can be either an anonymous function that returns the id value,
     * or an [[Expression]] object representing a DB expression (e.g. `new Expression('NOW()')`).
     * If not set, it will use the value of `ip2long(\Yii::$app->request->getUserIp())` to set the attributes.
     */
    public $value;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->userIpAtAttribute,
            ];
        }
    }

    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        if ($this->value instanceof Expression) {
            return $this->value;
        } else {
            return is_callable($this->value)
                ? call_user_func($this->value, $event)
                : $this->getDefaultValue();
        }
    }

    /**
     * @return int|null
     */
    protected function getDefaultValue()
    {
        return D::Request() instanceof \yii\web\Request
            ? D::Request()->getUserIP()
            : null;
    }
}
