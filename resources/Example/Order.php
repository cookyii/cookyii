<?php
/**
 * Order.php
 * @author Revin Roman http://phptime.ru
 */

namespace resources\Example;

/**
 * Class Order
 * @package resources\Example
 *
 * @property integer $id
 * @property string $number
 * @property integer $client_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $deleted
 *
 * @property Client $client
 */
class Order extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\BlameableBehavior::class,
            \yii\behaviors\TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['number', 'name', 'email', 'phone'], 'string'],
            [['client_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['deleted'], 'boolean'],

            /** semantic validators */
            [['number', 'client_id'], 'required'],
            [['number', 'name', 'email', 'phone'], 'filter', 'filter' => 'trim'],
            [['email'], 'email'],

            /** default values */
            [['deleted'], 'default', 'value' => self::NOT_DELETED],
        ];
    }

    /**
     * @return \resources\Example\queries\OrderQuery
     */
    public static function find()
    {
        return new \resources\Example\queries\OrderQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    const NOT_DELETED = 0;
    const DELETED = 1;
}