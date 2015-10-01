<?php
/**
 * ClientProperty.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\resources;

/**
 * Class ClientProperty
 * @package cookyii\modules\Client\resources
 *
 * @property integer $client_id
 * @property string $key
 * @property string $value
 * @property integer $created_at
 * @property integer $updated_at
 */
class ClientProperty extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
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
            'client_id' => \Yii::t('client', 'Client'),
            'key' => \Yii::t('client', 'Key'),
            'value' => \Yii::t('client', 'Value'),
            'created_at' => \Yii::t('client', 'Created at'),
            'updated_at' => \Yii::t('client', 'Updated at'),
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
     * @return \cookyii\modules\Client\resources\queries\ClientPropertyQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Client\resources\queries\ClientPropertyQuery::className(), [
                get_called_class(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client_property}}';
    }
}