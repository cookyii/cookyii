<?php
/**
 * AccountEditForm.php
 * @author Revin Roman http://phptime.ru
 */

namespace backend\modules\Account\forms;

use rmrevin\yii\rbac\RbacFactory;

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
    public $roles = [];
    public $activated;
    public $deleted;

    public function init()
    {
        if (!($this->User instanceof \resources\User)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('account', 'Not specified user to edit.'));
        }

        $User = $this->User;

        if (false === $User->isNewRecord) {
            $this->name = $User->name;
            $this->email = $User->email;
            $this->activated = $User->activated;
            $this->deleted = $User->deleted;

            $Roles = AuthManager()->getRolesByUser($User->id);
            foreach ($Roles as $role => $Role) {
                $this->roles[] = $role;
            }
        } else {

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
        $roles = array_keys(\resources\User::getAllRoles());
        foreach ($this->$attribute as $role => $value) {
            if (false === in_array($role, $roles)) {
                $this->addError($attribute, \Yii::t('account', 'Bad role'));
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
        return \resources\User::getAllRoles();
    }
}