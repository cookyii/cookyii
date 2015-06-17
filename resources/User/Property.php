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
 * @property string $value
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
            [['key', 'value'], 'string'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],

            /** semantic validators */
            [['user_id', 'key'], 'required'],
            [['key', 'value'], 'filter', 'filter' => 'str_clean'],

            /** default values */
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => \Yii::t('account', 'User'),
            'key' => \Yii::t('account', 'Key'),
            'value' => \Yii::t('account', 'Value'),
            'created_at' => \Yii::t('account', 'Created at'),
            'updated_at' => \Yii::t('account', 'Updated at'),
        ];
    }

    /**
     * @param integer $user_id
     * @param string $key
     * @param mixed $value
     * @return static
     * @throw \InvalidArgumentException
     */
    public static function push($user_id, $key, $value)
    {
        /** @var static $Property */
        $Property = static::find()
            ->byUserId($user_id)
            ->byKey($key)
            ->one();

        if (empty($Property)) {
            $Property = new static;
        }

        $Property->setAttributes([
            'user_id' => $user_id,
            'key' => $key,
            'value' => (string)$value,
        ]);

        $Property->validate() && $Property->save();

        return $Property;
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