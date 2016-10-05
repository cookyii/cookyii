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

    use traits\GetHelperTrait;

    /**
     * @var string
     */
    static $tableName;

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
     * @inheritdoc
     */
    public static function tableName()
    {
        return !empty(static::$tableName)
            ? static::$tableName
            : parent::tableName();
    }
}
