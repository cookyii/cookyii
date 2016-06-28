<?php
/**
 * Client.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\resources;

use cookyii\helpers\ApiAttribute;

/**
 * Class Client
 * @package resources
 *
 * @property integer $id
 * @property integer $account_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_at
 *
 * @property \cookyii\modules\Account\resources\Account $account
 * @property \cookyii\modules\Client\resources\ClientProperty[] $properties
 *
 * @property \cookyii\modules\Client\resources\helpers\ClientPresent $presentHelper
 * @property \cookyii\modules\Client\resources\helpers\ClientAccount $accountHelper
 */
class Client extends \cookyii\db\ActiveRecord
{

    use \cookyii\db\traits\SoftDeleteTrait;

    /**
     * @var string
     */
    public $presentHelperClass = 'cookyii\\modules\\Client\\resources\\helpers\\ClientPresent';

    /**
     * @var string
     */
    public $accountHelperClass = 'cookyii\\modules\\Client\\resources\\helpers\\ClientAccount';

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
            $fields['created_at'], $fields['updated_at'], $fields['deleted_at']
        );

        $fields['deleted'] = [$this, 'isDeleted'];

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        $fields = parent::extraFields();

        $fields['account'] = function (Client $Model) {
            $result = null;

            $Account = $Model->account;
            if (!empty($Account)) {
                $result = $Account->toArray();
            }

            return $result;
        };

        $fields['properties'] = function (Client $Model) {
            $result = [];

            $properties = $Model->properties();

            if (!empty($properties)) {
                foreach ($properties as $key => $values) {
                    $result[$key] = $values;
                }
            }

            return $result;
        };

        ApiAttribute::datetimeFormat($fields, 'created_at');
        ApiAttribute::datetimeFormat($fields, 'updated_at');
        ApiAttribute::datetimeFormat($fields, 'deleted_at');

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['name', 'email', 'phone'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'integer'],

            /** semantic validators */
            [['email'], 'email'],
            [['email'], 'unique', 'filter' => $this->isNewRecord ? null : ['not', ['id' => $this->id]]],
            [['name', 'email', 'phone'], 'filter', 'filter' => 'str_clean'],

            /** default values */
        ];
    }

    /**
     * @return \cookyii\db\helpers\NotificationHelper
     * @throws \yii\base\InvalidConfigException
     */
    public function getAccountHelper()
    {
        return $this->getHelper($this->accountHelperClass);
    }

    private $_properties = null;

    /**
     * @param bool $reload
     * @return array
     */
    public function properties($reload = false)
    {
        if ($this->_properties === null || $reload === true) {
            $this->_properties = [];

            $Properties = $this->properties;
            if (!empty($Properties)) {
                foreach ($Properties as $Property) {
                    $this->_properties[] = [
                        'key' => $Property->key,
                        'value' => $Property->value,
                    ];
                }
            }
        }

        return $this->_properties;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function property($key, $default = null)
    {
        $result = $default;

        $Properties = $this->properties;
        if (!empty($Properties)) {
            foreach ($Properties as $Property) {
                if ($key === $Property->key) {
                    $result = $Property->value;
                }
            }
        }

        return $result;
    }

    /**
     * @return \cookyii\modules\Client\resources\queries\ClientQuery
     */
    public function getAccount()
    {
        /** @var \cookyii\modules\Account\resources\Account $AccountModel */
        $AccountModel = \Yii::createObject(\cookyii\modules\Account\resources\Account::className());

        return $this->hasOne($AccountModel::className(), ['id' => 'account_id']);
    }

    /**
     * @return \cookyii\modules\Client\resources\queries\ClientQuery
     */
    public function getProperties()
    {
        /** @var \cookyii\modules\Client\resources\ClientProperty $ClientPropertyModel */
        $ClientPropertyModel = \Yii::createObject(\cookyii\modules\Client\resources\ClientProperty::className());

        return $this->hasMany($ClientPropertyModel::className(), ['client_id' => 'id']);
    }

    /**
     * @return \cookyii\modules\Client\resources\queries\ClientQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Client\resources\queries\ClientQuery::className(), [
                get_called_class(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client}}';
    }
}
