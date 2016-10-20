<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\Account;

use cookyii\modules\Account\resources\AccountAlert\Model as AccountAlertModel;
use cookyii\modules\Account\resources\AccountProperty\Model as AccountPropertyModel;
use yii\helpers\ArrayHelper;

/**
 * Class Model
 * @package cookyii\modules\Account\resources\Account
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $avatar
 * @property integer $gender
 * @property integer $timezone
 * @property string $password_hash
 * @property string $token
 * @property string $auth_key
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_at
 * @property integer $activated_at
 *
 * @property AccountPropertyModel[] $properties
 * @property AccountAlertModel[] $alerts
 *
 * @property helpers\PresentHelper $presentHelper
 * @property helpers\NotificationHelper $notificationHelper
 */
class Model extends \cookyii\db\ActiveRecord implements \yii\web\IdentityInterface, \cookyii\interfaces\AccountInterface
{

    use Serialize,
        traits\SocialTrait,
        \cookyii\db\traits\ActivationTrait,
        \cookyii\db\traits\SoftDeleteTrait;

    static $tableName = '{{%account}}';

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $presentHelperClass = helpers\PresentHelper::class;

    /**
     * @var string
     */
    public $notificationHelperClass = helpers\NotificationHelper::class;

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
     * Register event handlers
     */
    protected function registerEventHandlers()
    {
        $this->on(static::EVENT_BEFORE_INSERT, [$this, 'appendDataBeforeInsert']);
        $this->on(static::EVENT_BEFORE_UPDATE, [$this, 'updatePasswordHashBeforeUpdate']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['name', 'avatar', 'password', 'password_hash'], 'string'],
            [['gender', 'timezone', 'status', 'created_at', 'updated_at', 'activated_at', 'deleted_at'], 'integer'],

            /** semantic validators */
            [['email'], 'email'],
            [['email'], 'unique', 'filter' => $this->isNewRecord ? null : ['not', ['id' => $this->id]]],
            [['name', 'email', 'avatar'], 'filter', 'filter' => 'str_clean'],
            [['gender'], 'in', 'range' => array_keys(static::getGenderValues())],
            [['status'], 'in', 'range' => array_keys(static::getAllStatusValues())],

            /** default values */
            [['gender'], 'default', 'value' => static::MALE],
            [['status'], 'default', 'value' => static::STATUS_NULL],
        ];
    }

    /**
     * @return bool|string
     */
    public function isAvailable()
    {
        $result = true;

        if (empty($this->activated_at)) {
            $result = 'not-activated';
        } elseif (!empty($this->deleted_at)) {
            $result = 'deleted';
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isMale()
    {
        return $this->gender === static::MALE;
    }

    /**
     * @return bool
     */
    public function isFemale()
    {
        return $this->gender === static::FEMALE;
    }

    /** @var array */
    private $_access = [];

    /**
     * @param string $permissionName
     * @param array $params
     * @param boolean $allowCaching
     * @return boolean
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        if ($allowCaching && empty($params) && isset($this->_access[$permissionName])) {
            return $this->_access[$permissionName];
        }
        $access = AuthManager()->checkAccess($this->id, $permissionName, $params);
        if ($allowCaching && empty($params)) {
            $this->_access[$permissionName] = $access;
        }

        return $access;
    }

    /**
     * @return string
     */
    public function getEncryptKey()
    {
        return sha1($this->created_at . $this->auth_key . $this->email);
    }

    /**
     * @return \cookyii\modules\Account\resources\Account\helpers\Present
     * @throws \yii\base\InvalidConfigException
     */
    public function getPresentHelper()
    {
        return $this->getHelper($this->presentHelperClass);
    }

    /**
     * @return \cookyii\modules\Account\resources\Account\helpers\Notification
     * @throws \yii\base\InvalidConfigException
     */
    public function getNotificationHelper()
    {
        return $this->getHelper($this->notificationHelperClass);
    }

    /**
     * @param bool $save
     * @return string
     */
    public function refreshToken($save = true)
    {
        $token = Security()->generateRandomString();

        $this->token = $token;

        $this->validate() && ($save && $this->save());

        return $token;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()
            ->byId($id)
            ->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->byToken($token)
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Security()->validatePassword($password, $this->password_hash);
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $result = [];

        $roles = static::getAllRoles();
        $Assignments = AuthManager()->getAssignments($this->id);

        foreach (array_keys($Assignments) as $role) {
            $result[$role] = $roles[$role];
        }

        unset($result['user']);

        return $result;
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
     * @return \cookyii\modules\Account\resources\AccountProperty\Query
     */
    public function getProperties()
    {
        /** @var AccountPropertyModel $AccountPropertyModel */
        $AccountPropertyModel = \Yii::createObject(AccountPropertyModel::className());

        return $this->hasMany($AccountPropertyModel::className(), ['account_id' => 'id']);
    }

    /**
     * @return \cookyii\modules\Account\resources\AccountAlert\Query
     */
    public function getAlerts()
    {
        /** @var AccountAlertModel $AccountAlertModel */
        $AccountAlertModel = \Yii::createObject(AccountAlertModel::className());

        /** @var \cookyii\modules\Account\resources\AccountAlert\Query $Query */
        $Query = $this->hasMany($AccountAlertModel::className(), ['account_id' => 'id']);

        return $Query
            ->withoutDeleted();
    }

    /**
     * @return Query
     */
    public static function find()
    {
        return \Yii::createObject(Query::class, [get_called_class()]);
    }

    /**
     * @return array
     */
    public static function getAllRoles()
    {
        return ArrayHelper::map(AuthManager()->getRoles(), 'name', 'description');
    }

    /**
     * @return array
     */
    public static function getAllPermissions()
    {
        return ArrayHelper::map(AuthManager()->getPermissions(), 'name', 'description');
    }

    /**
     * @return array
     */
    public static function getGenderValues()
    {
        return [
            static::MALE => \Yii::t('cookyii.account', 'Male'),
            static::FEMALE => \Yii::t('cookyii.account', 'Female'),
        ];
    }

    /**
     * @return array
     */
    public function getAllStatusValues()
    {
        return [
            static::STATUS_NULL => \Yii::t('cookyii.account', 'New user'),
            static::STATUS_APPROVED => \Yii::t('cookyii.account', 'Approved'),
            static::STATUS_HOLD => \Yii::t('cookyii.account', 'Hold'),
            static::STATUS_BANNED => \Yii::t('cookyii.account', 'Banned'),
        ];
    }

    /**
     * @param \yii\base\ModelEvent $Event
     * @throws \yii\base\Exception
     */
    public function appendDataBeforeInsert(\yii\base\ModelEvent $Event)
    {
        /** @var static $Model */
        $Model = $Event->sender;

        $Model->password_hash = empty($this->password) ? null : Security()->generatePasswordHash($this->password);
        $Model->timezone = isset($_COOKIE['timezone']) && !empty($_COOKIE['timezone']) ? $_COOKIE['timezone'] : 0;
        $Model->auth_key = Security()->generateRandomString();
        $Model->token = Security()->generateRandomString();
    }

    /**
     * @param \yii\base\ModelEvent $Event
     * @throws \yii\base\Exception
     */
    public function updatePasswordHashBeforeUpdate(\yii\base\ModelEvent $Event)
    {
        /** @var static $Model */
        $Model = $Event->sender;

        if (!empty($this->password)) {
            $Model->password_hash = Security()->generatePasswordHash($this->password);
        }
    }

    const MALE = 1;
    const FEMALE = 2;

    const STATUS_NULL = 0;
    const STATUS_APPROVED = 100;
    const STATUS_HOLD = 200;
    const STATUS_BANNED = 300;
}
