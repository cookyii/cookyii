<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\resources\Client;

use cookyii\modules\Account\resources\Account\Model as AccountModel;
use cookyii\modules\Client\resources\ClientProperty\Model as ClientPropertyModel;

/**
 * Class Model
 * @package cookyii\modules\Client\resources\Client
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
 * @property AccountModel $account
 * @property ClientPropertyModel[] $properties
 *
 * @property helpers\PresentHelper $presentHelper
 * @property helpers\AccountHelper $accountHelper
 */
class Model extends \cookyii\db\ActiveRecord
{

    use Serialize,
        \cookyii\db\traits\SoftDeleteTrait;

    static $tableName = '{{%client}}';

    /**
     * @var string
     */
    public $presentHelperClass = helpers\PresentHelper::class;

    /**
     * @var string
     */
    public $accountHelperClass = helpers\AccountHelper::class;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['timestamp'] = \cookyii\behaviors\TimestampBehavior::class;

        return $behaviors;
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
     * @return helpers\AccountHelper
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
     * @return \cookyii\modules\Account\resources\Account\Query
     */
    public function getAccount()
    {
        /** @var AccountModel $AccountModel */
        $AccountModel = \Yii::createObject(AccountModel::className());

        return $this->hasOne($AccountModel::className(), ['id' => 'account_id']);
    }

    /**
     * @return \cookyii\modules\Client\resources\ClientProperty\Query
     */
    public function getProperties()
    {
        /** @var ClientPropertyModel $ClientPropertyModel */
        $ClientPropertyModel = \Yii::createObject(ClientPropertyModel::className());

        return $this->hasMany($ClientPropertyModel::className(), ['client_id' => 'id']);
    }

    /**
     * @return Query
     */
    public static function find()
    {
        return \Yii::createObject(Query::class, [get_called_class()]);
    }
}
