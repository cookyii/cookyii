<?php
/**
 * ActiveRecord.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\db;

/**
 * Class ActiveRecord
 * @package cookyii\db
 */
abstract class ActiveRecord extends \yii\db\ActiveRecord
{

    /**
     * @var string
     */
    static $tableName;

    /**
     * @var \cookyii\db\helpers\AbstractHelper[]
     */
    private $_helpers = [];

    /**
     * @inheritdoc;
     */
    public function init()
    {
        parent::init();

        $this->registerEventHandlers();
    }

    /**
     * Register event handlers
     */
    protected function registerEventHandlers()
    {
        // override method
    }

    /**
     * @return bool
     */
    public function isDirty()
    {
        return !empty($this->dirtyAttributes);
    }

    /**
     * @param string $helperClass
     * @return helpers\AbstractHelper
     * @throws \yii\base\InvalidConfigException
     */
    protected function getHelper($helperClass)
    {
        if (empty($helperClass)) {
            throw new \yii\base\InvalidConfigException('The "presentHelperClass" property must be set.');
        }

        if (!class_exists($helperClass)) {
            throw new \yii\base\InvalidConfigException(sprintf('Class "%s" not found.', $this->presentHelperClass));
        }

        if (!isset($this->_helpers[$helperClass])) {
            $this->_helpers[$helperClass] = \Yii::createObject([
                'class' => $helperClass,
                'Model' => $this,
            ]);
        }

        return $this->_helpers[$helperClass];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return !empty(static::$tableName)
            ? static::$tableName
            : parent::tableName();
    }
}
