<?php
/**
 * UniqueCodeIdBehavior.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\behaviors;

use cookyii\Facade as F;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * Class UniqueCodeIdBehavior
 * @package cookyii\behaviors
 */
class UniqueCodeIdBehavior extends \yii\behaviors\AttributeBehavior
{

    /**
     * @var string the attribute that will receive id value
     */
    public $codeAtAttribute = 'id';

    /**
     * @var array length of random value
     */
    public $length = [6, 12];

    /**
     * @var callable|\yii\db\Expression The expression that will be used for generating the id.
     * This can be either an anonymous function that returns the id value,
     * or an [[Expression]] object representing a DB expression (e.g. `new Expression('NOW()')`).
     * If not set, it will use the value of `\Yii::$app->security->generateRandomString(10)` to set the attributes.
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
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->codeAtAttribute,
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
     * @return string
     */
    public function getDefaultValue()
    {
        $length = $this->length;
        $length = is_array($length)
            ? (int)rand(array_shift($length), array_shift($length))
            : (int)$length;

        $length = $length <= 0 ? 12 : $length;
        $length = $length > 32 ? 32 : $length;

        return F::Security()->generateRandomString($length);
    }
}
