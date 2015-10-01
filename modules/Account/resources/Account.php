<?php
/**
 * Account.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

use yii\helpers\ArrayHelper;

/**
 * Class Account
 * @package cookyii\modules\Account\resources
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $avatar
 * @property string $password_hash
 * @property string $token
 * @property string $auth_key
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_at
 * @property integer $activated_at
 *
 * @property \cookyii\modules\Account\resources\AccountProperty[] $properties
 *
 * @property \cookyii\modules\Account\resources\helpers\AccountPresent $presentHelper
 * @property \cookyii\modules\Account\resources\helpers\AccountNotification $notificationHelper
 *
 * @method \cookyii\modules\Account\resources\queries\AccountQuery hasMany($class, $link)
 * @method \cookyii\modules\Account\resources\queries\AccountQuery hasOne($class, $link)
 */
class Account extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface, \cookyii\interfaces\AccountInterface
{

    use \cookyii\modules\Account\resources\Account\traits\UserSocialTrait,
        \cookyii\db\traits\ActivationTrait,
        \cookyii\db\traits\SoftDeleteTrait;

    public $password;

    public static $gravatarParams = [
        'r' => 'r',
        's' => 128,
        'd' => 'retro',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->events();
    }

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

        unset($fields['password_hash'], $fields['token'], $fields['auth_key']);

        $fields['created_at_format'] = function (Account $Model) {
            return Formatter()->asDatetime($Model->created_at);
        };

        $fields['updated_at_format'] = function (Account $Model) {
            return Formatter()->asDatetime($Model->updated_at);
        };

        $fields['deleted_at_format'] = function (Account $Model) {
            return Formatter()->asDatetime($Model->deleted_at);
        };

        $fields['activated_at_format'] = function (Account $Model) {
            return Formatter()->asDatetime($Model->activated_at);
        };

        $fields['deleted'] = [$this, 'isDeleted'];
        $fields['activated'] = [$this, 'isActivated'];

        $fields['gravatar'] = 'gravatar';

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        $fields = parent::extraFields();

        $fields['roles'] = function (Account $Model) {
            $result = [];

            $roles = AuthManager()->getRolesByUser($Model->id);

            foreach ($roles as $role => $conf) {
                $result[$role] = true;
            }

            $result[\common\Roles::USER] = true;

            return $result;
        };

        $fields['permissions'] = function (Account $Model) {
            $result = [];

            $permissions = AuthManager()->getPermissionsByUser($Model->id);

            foreach ($permissions as $permission => $conf) {
                $result[$permission] = true;
            }

            return $result;
        };

        $fields['properties'] = function (Account $Model) {
            return $Model->properties();
        };

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['name', 'avatar', 'password', 'password_hash'], 'string'],
            [['created_at', 'updated_at', 'activated_at', 'deleted_at'], 'integer'],

            /** semantic validators */
            [['email'], 'email'],
            [['email'], 'unique', 'filter' => $this->isNewRecord ? null : ['not', ['id' => $this->id]]],
            [['email'], 'required'],
            [['name', 'email', 'avatar'], 'filter', 'filter' => 'str_clean'],

            /** default values */
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
     * @return string
     */
    public function getGravatar()
    {
        $hash = md5(strtolower(trim($this->email)));

        $params = array_merge([
            'r' => 'r',
            's' => 128,
            'd' => 'retro',
        ], static::$gravatarParams);

        return sprintf('https://secure.gravatar.com/avatar/%s.png?%s', $hash, http_build_query($params));
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

    protected $presentHelper = null;

    /**
     * @return \cookyii\modules\Account\resources\helpers\AccountPresent
     * @throws \yii\base\InvalidConfigException
     */
    public function getPresentHelper()
    {
        if ($this->presentHelper === null) {
            $this->presentHelper = \Yii::createObject([
                'class' => \cookyii\modules\Account\resources\helpers\AccountPresent::className(),
                'Model' => $this,
            ]);
        }

        return $this->presentHelper;
    }

    protected $notificationHelper = null;

    /**
     * @return \cookyii\modules\Account\resources\helpers\AccountNotification
     * @throws \yii\base\InvalidConfigException
     */
    public function getNotificationHelper()
    {
        if ($this->notificationHelper === null) {
            $this->notificationHelper = \Yii::createObject([
                'class' => \cookyii\modules\Account\resources\helpers\AccountNotification::className(),
                'Model' => $this,
            ]);
        }

        return $this->notificationHelper;
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
     * @return \cookyii\modules\Account\resources\queries\AccountQuery
     */
    public function getProperties()
    {
        /** @var \cookyii\modules\Account\resources\AccountProperty $AccountPropertyModel */
        $AccountPropertyModel = \Yii::createObject(\cookyii\modules\Account\resources\AccountProperty::className());

        return $this->hasMany($AccountPropertyModel::className(), ['account_id' => 'id']);
    }

    /**
     * @return \cookyii\modules\Account\resources\queries\AccountQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Account\resources\queries\AccountQuery::className(),
            [get_called_class()]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account}}';
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
     * Events
     */
    private function events()
    {
        $this->on(
            static::EVENT_BEFORE_INSERT,
            function (\yii\base\ModelEvent $Event) {
                /** @var static $Model */
                $Model = $Event->sender;
                $Model->password_hash = Security()->generatePasswordHash($this->password);
                $Model->auth_key = Security()->generateRandomString();
                $Model->token = Security()->generateRandomString();
            }
        );

        $this->on(
            static::EVENT_BEFORE_UPDATE,
            function (\yii\base\ModelEvent $Event) {
                /** @var static $Model */
                $Model = $Event->sender;
                if (!empty($this->password)) {
                    $Model->password_hash = Security()->generatePasswordHash($this->password);
                }
            }
        );
    }
}