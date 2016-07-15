<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace resources\Blank;

/**
 * Class Model
 * @package resources\Blank
 *
 * @property integer $id
 * @property string $title
 * @property integer $sort
 */
class Model extends \cookyii\db\ActiveRecord
{

    static $tableName = '{{%table_name}}';

    /**
     * @return Query
     */
    public static function find()
    {
        return new Query(get_called_class());
    }
}
