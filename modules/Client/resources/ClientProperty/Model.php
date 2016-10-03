<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\resources\ClientProperty;

/**
 * Class Model
 * @package cookyii\modules\Client\resources\ClientProperty
 *
 * @property integer $client_id
 * @property string $key
 * @property string $value
 * @property integer $created_at
 * @property integer $updated_at
 */
class Model extends \cookyii\db\ActiveRecord
{

    use Serialize;

    static $tableName = '{{%client_property}}';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => \cookyii\behaviors\TimestampBehavior::className(),
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
            [['client_id', 'created_at', 'updated_at'], 'integer'],

            /** semantic validators */
            [['client_id', 'key'], 'required'],
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
            'client_id' => \Yii::t('cookyii.client', 'Client'),
            'key' => \Yii::t('cookyii.client', 'Key'),
            'value' => \Yii::t('cookyii.client', 'Value'),
            'created_at' => \Yii::t('cookyii.client', 'Created at'),
            'updated_at' => \Yii::t('cookyii.client', 'Updated at'),
        ];
    }

    /**
     * @param integer $client_id
     * @param string $key
     * @param mixed $value
     * @return static
     * @throw \InvalidArgumentException
     */
    public static function push($client_id, $key, $value)
    {
        /** @var static $Property */
        $Property = static::find()
            ->byAccountId($client_id)
            ->byKey($key)
            ->one();

        if (empty($Property)) {
            $Property = new static;
        }

        $Property->setAttributes([
            'client_id' => $client_id,
            'key' => $key,
            'value' => (string)$value,
        ]);

        $Property->validate() && $Property->save();

        return $Property;
    }

    /**
     * @return Query
     */
    public static function find()
    {
        return \Yii::createObject(Query::class, [get_called_class()]);
    }
}
