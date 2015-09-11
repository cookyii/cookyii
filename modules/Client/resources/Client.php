<?php
/**
 * Client.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\resources;

use cookyii\modules\Account;

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
 * @property \cookyii\modules\Client\resources\Client\Property[] $properties
 *
 * @property \cookyii\modules\Client\resources\helpers\ClientPresent $present
 *
 * @method \cookyii\modules\Client\resources\queries\ClientQuery hasMany($class, $link)
 * @method \cookyii\modules\Client\resources\queries\ClientQuery hasOne($class, $link)
 */
class Client extends \yii\db\ActiveRecord
{

    use \cookyii\db\traits\SoftDeleteTrait;

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
    public function fields()
    {
        $fields = parent::fields();

        $fields['deleted'] = 'deleted';

        unset($fields['password_hash'], $fields['token'], $fields['auth_key']);

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

    private $present = null;

    /**
     * @return \cookyii\modules\Client\resources\helpers\ClientPresent
     * @throws \yii\base\InvalidConfigException
     */
    public function getPresent()
    {
        if ($this->present === null) {
            $this->present = \Yii::createObject([
                'class' => \cookyii\modules\Client\resources\helpers\ClientPresent::className(),
                'Model' => $this,
            ]);
        }

        return $this->present;
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
     * @param null|string $name
     * @param null|string $email
     * @return \cookyii\modules\Account\resources\Account
     * @throws \yii\base\Exception
     */
    public function createAccount($name = null, $email = null)
    {
        if ($this->isNewRecord) {
            throw new \yii\base\Exception(\Yii::t('client', 'You can not create an account from unsaved client.'));
        }

        $name = empty($name) ? $this->name : $name;
        $email = empty($email) ? $this->email : $email;

        /** @var Account\resources\Account $Account */
        $Account = Account\resources\Account::find()
            ->byEmail($email)
            ->one();

        if (empty($Account)) {
            $Account = new Account\resources\Account;
            $Account->setAttributes([
                'name' => $name,
                'email' => $email,
            ]);

            $Account->validate() && $Account->save();

            if (!$Account->hasErrors() && !$Account->isNewRecord) {
                $this->account_id = $Account->id;
                $this->validate() && $this->save();
            }
        }

        return $Account;
    }

    /**
     * @return \cookyii\modules\Account\resources\queries\AccountQuery
     */
    public function getProperties()
    {
        return $this->hasMany(\cookyii\modules\Client\resources\Client\Property::className(), ['client_id' => 'id']);
    }

    /**
     * @return \cookyii\modules\Client\resources\queries\ClientQuery
     */
    public static function find()
    {
        return new \cookyii\modules\Client\resources\queries\ClientQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client}}';
    }
}