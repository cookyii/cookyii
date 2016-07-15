<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\AccountProperty;

use cookyii\helpers\ApiAttribute;

/**
 * Class Model
 * @package cookyii\modules\Account\resources\AccountProperty
 *
 * @property integer $account_id
 * @property string $key
 * @property string $value
 * @property integer $created_at
 * @property integer $updated_at
 */
class Model extends \cookyii\db\ActiveRecord
{

    static $tableName = '{{%account_property}}';

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
    public function fields()
    {
        $fields = parent::fields();

        unset(
            $fields['account_id'],
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
            [['account_id', 'created_at', 'updated_at'], 'integer'],

            /** semantic validators */
            [['account_id', 'key'], 'required'],
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
            'account_id' => \Yii::t('cookyii.account', 'User'),
            'key' => \Yii::t('cookyii.account', 'Key'),
            'value' => \Yii::t('cookyii.account', 'Value'),
            'created_at' => \Yii::t('cookyii.account', 'Created at'),
            'updated_at' => \Yii::t('cookyii.account', 'Updated at'),
        ];
    }

    /**
     * @param integer $account_id
     * @param string $key
     * @param mixed $value
     * @param bool $replace
     * @return static
     * @throw \InvalidArgumentException
     */
    public static function push($account_id, $key, $value, $replace = true)
    {
        /** @var static $Property */
        $Property = static::find()
            ->byAccountId($account_id)
            ->byKey($key)
            ->one();

        if (empty($Property)) {
            $Property = new static;
        }

        if ($replace || $Property->isNewRecord) {
            $Property->setAttributes([
                'account_id' => $account_id,
                'key' => $key,
                'value' => (string)$value,
            ]);

            $Property->validate() && $Property->save();
        }

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
