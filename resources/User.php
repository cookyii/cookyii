<?php
/**
 * User.php
 * @author Revin Roman
 */

namespace resources;

/**
 * Class User
 * @package resources
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
 * @property boolean $activated
 * @property boolean $deleted
 *
 * @property \resources\User\Property[] $properties
 *
 * @property \resources\helpers\UserPresent $present
 *
 * @method queries\UserQuery hasMany($class, $link)
 * @method queries\UserQuery hasOne($class, $link)
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    use \resources\User\traits\UserSocialTrait;
    use \common\traits\ActiveRecord\ActivationTrait;
    use \common\traits\ActiveRecord\SoftDeleteTrait;

    public $password;

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password_hash'], $fields['token'], $fields['auth_key']);

        return $fields;
    }

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
            'yii\behaviors\TimestampBehavior',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['name', 'avatar', 'password', 'password_hash'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['activated', 'deleted'], 'boolean'],

            /** semantic validators */
            [['email'], 'email'],
            [['email'], 'unique', 'filter' => $this->isNewRecord ? null : ['not', ['id' => $this->id]]],
            [['email'], 'required'],
            [['name', 'email', 'avatar'], 'filter', 'filter' => 'str_clean'],
            [['activated'], 'in', 'range' => [self::NOT_ACTIVATED, self::ACTIVATED]],
            [['deleted'], 'in', 'range' => [self::NOT_DELETED, self::DELETED]],

            /** default values */
            [['activated'], 'default', 'value' => self::NOT_ACTIVATED],
            [['deleted'], 'default', 'value' => self::NOT_DELETED],
        ];
    }

    /**
     * @return bool|string
     */
    public function isAvailable()
    {
        $result = true;

        switch ($this->activated) {
            default:
            case \resources\User::NOT_ACTIVATED:
                $result = 'not-activated';
                break;
            case \resources\User::ACTIVATED:
                break;
        }

        switch ($this->deleted) {
            default:
            case \resources\User::DELETED:
                $result = 'deleted';
                break;
            case \resources\User::NOT_DELETED:
                break;
        }

        return $result;
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

    private $present = null;

    /**
     * @return \resources\helpers\UserPresent
     * @throws \yii\base\InvalidConfigException
     */
    public function getPresent()
    {
        if ($this->present === null) {
            $this->present = \Yii::createObject([
                'class' => 'resources\helpers\UserPresent',
                'Model' => $this,
            ]);
        }

        return $this->present;
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
                        'type' => (string)$Property->type,
                        'value' => $Property->value(),
                        'value_str' => $Property->value_str,
                        'value_int' => $Property->value_int,
                        'value_float' => $Property->value_float,
                        'value_text' => $Property->value_text,
                        'value_blob' => $Property->value_blob,
                    ];
                }
            }
        }

        return $this->_properties;
    }

    /**
     * @param string $key
     * @param string|null $type
     * @param mixed $default
     * @return mixed
     */
    public function property($key, $type = null, $default = null)
    {
        $result = $default;

        $Properties = $this->properties;
        if (!empty($Properties)) {
            foreach ($Properties as $Property) {
                if ($key === $Property->key) {
                    $result = $Property->value($type);
                }
            }
        }

        return $result;
    }

    /**
     * @return queries\UserQuery
     */
    public function getProperties()
    {
        return $this->hasMany('resources\User\Property', ['user_id' => 'id']);
    }

    /**
     * @return \resources\queries\UserQuery
     */
    public static function find()
    {
        return new \resources\queries\UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @return array
     */
    public static function getAllRoles()
    {
        return [
            \common\Roles::ADMIN => \Yii::t('account', 'Administrator'),
            \common\Roles::MANAGER => \Yii::t('account', 'Manager'),
            \common\Roles::CLIENT => \Yii::t('account', 'Client'),
            \common\Roles::USER => \Yii::t('account', 'User'),
        ];
    }

    /**
     * Events
     */
    private function events()
    {
        $this->on(
            self::EVENT_BEFORE_INSERT,
            function (\yii\base\ModelEvent $Event) {
                /** @var self $Model */
                $Model = $Event->sender;
                $Model->password_hash = Security()->generatePasswordHash($this->password);
                $Model->auth_key = Security()->generateRandomString();
                $Model->token = Security()->generateRandomString();
            }
        );


        $this->on(
            self::EVENT_BEFORE_UPDATE,
            function (\yii\base\ModelEvent $Event) {
                /** @var self $Model */
                $Model = $Event->sender;
                if (!empty($this->password)) {
                    $Model->password_hash = Security()->generatePasswordHash($this->password);
                }
            }
        );
    }

    const NOT_DELETED = 0;
    const DELETED = 1;

    const NOT_ACTIVATED = 0;
    const ACTIVATED = 1;
}