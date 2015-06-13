<?php
/**
 * AccountEditForm.php
 * @author Revin Roman http://phptime.ru
 */

namespace backend\modules\Account\forms;

use rmrevin\yii\rbac\RbacFactory;
use yii\helpers\ArrayHelper;

/**
 * Class AccountEditForm
 * @package backend\modules\Account\forms
 */
class AccountEditForm extends \yii\base\Model
{

    use \common\traits\ActiveRecord\PopulateErrorsTrait;

    /** @var \resources\User */
    public $User;

    public $name;
    public $email;
    public $activated;
    public $deleted;
    public $roles = [];
    public $permissions = [];

    public function init()
    {
        if (!($this->User instanceof \resources\User)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('account', 'Not specified user to edit.'));
        }

        $this->on(
            self::EVENT_BEFORE_VALIDATE,
            function (\yii\base\Event $Event) {
                /** @var self $Model */
                $Model = $Event->sender;
                $Model->roles[\common\Roles::USER] = true;
            }
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['name', 'email'], 'string'],
            [['activated', 'deleted'], 'boolean'],

            /** semantic validators */
            [['email'], 'required'],
            [['email'], 'email'],
            [['name', 'email'], 'filter', 'filter' => 'str_clean'],
            [['roles'], 'checkRoles', 'skipOnEmpty' => false],
            [['permissions'], 'checkPermissions', 'skipOnEmpty' => false],

            /** default values */
            [['activated'], 'default', 'value' => \resources\User::ACTIVATED],
            [['deleted'], 'default', 'value' => \resources\User::NOT_DELETED],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('account', 'Username'),
            'email' => \Yii::t('account', 'Email'),
            'roles' => \Yii::t('account', 'Roles'),
            'activated' => \Yii::t('account', 'Account activated'),
            'deleted' => \Yii::t('account', 'Account removed'),
        ];
    }

    /**
     * @return array
     */
    public function formAction()
    {
        return ['/rest/account/edit'];
    }

    /**
     * @return bool
     */
    public function isNewAccount()
    {
        return $this->User->isNewRecord;
    }

    /**
     * @param string $attribute
     */
    public function checkRoles($attribute)
    {
        $roles = static::getRoleValues();
        foreach ($this->$attribute as $role => $value) {
            if (!isset($roles[$role])) {
                $this->addError($attribute, \Yii::t('account', 'Bad role'));
            }
        }
    }

    /**
     * @param string $attribute
     */
    public function checkPermissions($attribute)
    {
        $permissions = static::getPermissionValues();
        foreach ($this->$attribute as $permission => $value) {
            if (!isset($permissions[$permission])) {
                $this->addError($attribute, \Yii::t('account', 'Bad permission'));
            }
        }
    }

    /**
     * @return bool
     */
    public function save()
    {
        $User = $this->User;

        $User->name = $this->name;
        $User->email = $this->email;
        $User->activated = $this->activated;
        $User->deleted = $this->deleted;

        $result = $User->validate() && $User->save();

        if ($User->hasErrors()) {
            $this->populateErrors($User, 'name');
        } else {
            AuthManager()->revokeAll($User->id);
            foreach ($this->roles as $role => $value) {
                if ($value === true) {
                    AuthManager()->assign(RbacFactory::Role($role), $User->id);
                }
            }
        }

        AuthManager()->invalidateCache();

        $this->User = $User;

        return $result;
    }

    /**
     * @return array
     */
    public static function getRoleValues()
    {
        return ArrayHelper::map(AuthManager()->getRoles(), 'name', 'description');
    }

    /**
     * @return array
     */
    public static function getPermissionValues()
    {
        return ArrayHelper::map(AuthManager()->getPermissions(), 'name', 'description');
    }

    /**
     * @return array
     */
    public static function getGroupedPermissionValues()
    {
        $permissions = static::getPermissionValues();

        $result = [
            'items' => [],
            'children' => [],
        ];

        if (!empty($permissions)) {
            foreach ($permissions as $permission => $description) {
                if (empty($permission)) {
                    continue;
                }

                $part = explode('.', $permission);

                if (empty($part) || count($part) < 1) {
                    continue;
                }

                $count = count($part);

                if ($count === 1) {
                    if (!in_array($permission, $result['items'], true)) {
                        $result['items'][$permission] = $description;
                    }
                } else {
                    $g1 = sprintf('%s.*', $part[0]);

                    if (!isset($result['children'][$g1])) {
                        $result['children'][$g1] = [
                            'items' => [],
                        ];
                    }

                    if (!in_array($permission, $result['children'][$g1]['items'], true)) {
                        $result['children'][$g1]['items'][$permission] = $description;
                    }
                }
            }
        }

        return $result;
    }
}