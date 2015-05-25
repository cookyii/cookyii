<?php
/**
 * Client.php
 * @author Revin Roman http://phptime.ru
 */

namespace resources\Example;

/**
 * Class Client
 * @package resources\Example
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $deleted
 */
class Client extends \yii\db\ActiveRecord
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
            [['name', 'email', 'phone'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['deleted'], 'boolean'],

            /** semantic validators */
            [['name'], 'required'],
            [['name', 'email', 'phone'], 'filter', 'filter' => 'trim'],
            [['email'], 'email'],

            /** default values */
            [['deleted'], 'default', 'value' => self::NOT_DELETED],
        ];
    }

    /**
     * @return \resources\Example\queries\ClientQuery
     */
    public static function find()
    {
        return new \resources\Example\queries\ClientQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client}}';
    }

    const NOT_DELETED = 0;
    const DELETED = 1;
}