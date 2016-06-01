<?php
/**
 * AccountProperty.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

use cookyii\helpers\ApiAttribute;

/**
 * Class AccountProperty
 * @package cookyii\modules\Account\resources
 *
 * @property integer $account_id
 * @property string $key
 * @property string $value
 * @property integer $created_at
 * @property integer $updated_at
 */
class AccountProperty extends \cookyii\db\ActiveRecord
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
     * @return \cookyii\modules\Account\resources\queries\AccountPropertyQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Account\resources\queries\AccountPropertyQuery::className(),
            [get_called_class()]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_property}}';
    }
}
