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
 * @property integer $type
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

    const TYPE_STRING = 100;
    const TYPE_INTEGER = 200;
    const TYPE_FLOAT = 300;
    const TYPE_TEXT = 400;
    const TYPE_BLOB = 500;

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
            [['user_id', 'type', 'value_int', 'created_at', 'updated_at'], 'integer'],
            [['value_float'], 'number'],

            /** semantic validators */
            [['user_id', 'type', 'key'], 'required'],
            [['key', 'value_str', 'value_int', 'value_float', 'value_text', 'value_blob'], 'filter', 'filter' => 'str_clean'],
            [['type'], 'in', 'range' => array_keys(static::getAllTypes())],

            /** default values */
        ];
    }

    /**
     * @param integer|null $type
     * @return mixed
     */
    public function value($type = null)
    {
        $result = null;

        $type = empty($type)
            ? $this->type
            : $type;

        switch ($type) {
            case static::TYPE_STRING:
                $result = $this->value_str;
                break;
            case static::TYPE_INTEGER:
                $result = $this->value_int;
                break;
            case static::TYPE_FLOAT:
                $result = $this->value_float;
                break;
            case static::TYPE_TEXT:
                $result = $this->value_text;
                break;
            case static::TYPE_BLOB:
                $result = $this->value_blob;
                break;
        }

        return $result;
    }

    /**
     * @param integer $user_id
     * @param string $key
     * @param integer $type
     * @param mixed $value
     * @return static
     * @throw \InvalidArgumentException
     */
    public static function push($user_id, $key, $type, $value)
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
            'type' => $type,
        ]);

        switch ($type) {
            default:
                throw new \InvalidArgumentException(\Yii::t('account', 'Invalid property type (use `Property::TYPE_*`)'));
            case static::TYPE_STRING:
                $Property->value_str = (string)$value;
                break;
            case static::TYPE_INTEGER:
                $Property->value_int = (integer)$value;
                break;
            case static::TYPE_FLOAT:
                $Property->value_float = (float)$value;
                break;
            case static::TYPE_TEXT:
                $Property->value_text = (string)$value;
                break;
            case static::TYPE_BLOB:
                $Property->value_blob = $value;
                break;
        }

        $Property->validate() && $Property->save();

        return $Property;
    }

    /**
     * @return array
     */
    public static function getAllTypes()
    {
        return [
            static::TYPE_STRING => \Yii::t('account', 'String'),
            static::TYPE_INTEGER => \Yii::t('account', 'Integer'),
            static::TYPE_FLOAT => \Yii::t('account', 'Float'),
            static::TYPE_TEXT => \Yii::t('account', 'Text'),
            static::TYPE_BLOB => \Yii::t('account', 'Blob'),
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