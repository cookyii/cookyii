<?php
/**
 * Property.php
 * @author Revin Roman
 */

namespace resources\User;

/**
 * Class Property
 * @package resources\User
 *
 * @property integer $user_id
 * @property string $key
 * @property string $value_str
 * @property integer $value_int
 * @property float $value_float
 * @property string $value_text
 * @property string $value_blob
 * @property integer $created_at
 * @property integer $updated_at
 */
class Property extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['key', 'value_str', 'value_text', 'value_blob'], 'string'],
            [['user_id', 'value_int', 'created_at', 'updated_at'], 'integer'],
            [['value_float'], 'number'],

            /** semantic validators */
            [['user_id', 'key'], 'required'],
            [['key', 'value_str', 'value_int', 'value_float', 'value_text', 'value_blob'], 'filter', 'filter' => 'str_clean'],

            /** default values */
        ];
    }

    /**
     * @return queries\UserPropertyQuery
     */
    public static function find()
    {
        return new \resources\User\queries\UserPropertyQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_property}}';
    }
}