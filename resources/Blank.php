<?php
/**
 * Blank.php
 * @author Revin Roman http://phptime.ru
 */

namespace resources;

/**
 * Class Blank
 * @package resources
 *
 * @property integer $id
 * @property string $title
 * @property integer $sort
 */
class Blank extends \yii\db\ActiveRecord
{

    /**
     * @return \resources\queries\BlankQuery
     */
    public static function find()
    {
        return new \resources\queries\BlankQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%table_name}}';
    }
}