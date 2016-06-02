<?php
/**
 * ClientProperty.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\resources;

use cookyii\helpers\ApiAttribute;

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
class ClientProperty extends \cookyii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \cookyii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        unset(
            $fields['client_id'],
            $fields['created_at'], $fields['updated_at']
        );

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        $fields = parent::extraFields();

        ApiAttribute::datetimeFormat($fields, 'created_at');
        ApiAttribute::datetimeFormat($fields, 'updated_at');

        return $fields;
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
