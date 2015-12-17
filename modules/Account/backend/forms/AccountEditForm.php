<?php
/**
 * AccountEditForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend\forms;

use cookyii\modules\Account;
use rmrevin\yii\rbac\RbacFactory;

/**
 * Class AccountEditForm
 * @package cookyii\modules\Account\backend\forms
 */
class AccountEditForm extends \cookyii\base\FormModel
{

    use \cookyii\traits\PopulateErrorsTrait;

    /** @var \cookyii\modules\Account\resources\Account */
    public $Account;

    public $name;
    public $email;
    public $gender;
    public $roles;
    public $new_password;
    public $new_password_app;

    public function init()
    {
        if (!($this->Account instanceof \cookyii\modules\Account\resources\Account)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('cookyii.account', 'Not specified account to edit.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['name', 'email', 'new_password', 'new_password_app'], 'string'],
            [['gender'], 'integer'],

            /** semantic validators */
            [['name', 'email'], 'required'],
            [['email'], 'email'],
            [['name', 'email'], 'filter', 'filter' => 'str_clean'],
            [['roles'], 'checkRoles'],
            [['new_password_app'], 'compare', 'compareAttribute' => 'new_password', 'operator' => '==='],

            /** default values */
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('cookyii.account', 'Username'),
            'email' => \Yii::t('cookyii.account', 'Email'),
            'roles' => \Yii::t('cookyii.account', 'Roles'),
            'new_password' => \Yii::t('cookyii.account', 'New password'),
            'new_password_app' => \Yii::t('cookyii.account', 'Approve new password'),
        ];
    }

    /**
     * @return array
     */
    public function formAction()
    {
        return ['/account/rest/account/edit'];
    }

    /**
     * @return bool
     */
    public function isNewAccount()
    {
        return $this->Account->isNewRecord;
    }

    /**
     * @param string $attribute
     * @throws \yii\base\InvalidConfigException
     */
    public function checkRoles($attribute)
    {
        $values = $this->$attribute;
        if (empty($values)) {
            $this->addError($attribute, \Yii::t('cookyii.account', 'You must select at least one role'));
        } else {
            /** @var Account\resources\Account $Account */
            $Account = \Yii::createObject([
                'class' => Account\resources\Account::className(),
            ]);

            $roles = array_keys($Account::getAllRoles());

            $allright = false;
            foreach ($values as $role => $checked) {
                if ($checked === true) {
                    if (!in_array($role, $roles, true)) {
                        $this->addError($attribute, \Yii::t('cookyii.account', 'The role of `{role}` is not found', [
                            'role' => $role,
                        ]));
                    } else {
                        $allright = true;
                    }
                }
            }

            if (!$allright) {
                $this->addError($attribute, \Yii::t('cookyii.account', 'You must select at least one role'));
            }
        }
    }

    /**
     * @return bool
     */
    public function save()
    {
        $Account = $this->Account;

        $Account->name = $this->name;
        $Account->email = $this->email;
        $Account->gender = $this->gender;

        if ($Account->isNewRecord) {
            $Account->activated_at = time();
        }

        if (!empty($this->new_password)) {
            $Account->password = $this->new_password;
        }

        $result = $Account->validate() && $Account->save();

        if ($Account->hasErrors()) {
            $this->populateErrors($Account, 'name');
        } else {
            AuthManager()->revokeAll($Account->id);

            $roles = $this->roles;
            if (!empty($roles)) {
                foreach ($roles as $role => $checked) {
                    if ($checked === true) {
                        AuthManager()->assign(RbacFactory::Role($role), $Account->id);
                    }
                }
            }
        }

        if (AuthManager() instanceof \yii\rbac\DbManager) {
            AuthManager()->invalidateCache();
        }

        $this->Account = $Account;

        return $result;
    }

    /**
     * @return array
     */
    public static function getRoleValues()
    {
        /** @var \cookyii\modules\Account\resources\Account $AccountModel */
        $AccountModel = \Yii::createObject(\cookyii\modules\Account\resources\Account::className());

        return $AccountModel::getAllRoles();
    }

    /**
     * @return array
     */
    public static function getGenderValues()
    {
        /** @var \cookyii\modules\Account\resources\Account $AccountModel */
        $AccountModel = \Yii::createObject(\cookyii\modules\Account\resources\Account::className());

        return $AccountModel::getGenderValues();
    }

    /**
     * @return array
     */
    public static function getGroupedPermissionValues()
    {
        /** @var \cookyii\modules\Account\resources\Account $AccountModel */
        $AccountModel = \Yii::createObject(\cookyii\modules\Account\resources\Account::className());

        $permissions = $AccountModel::getAllPermissions();

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