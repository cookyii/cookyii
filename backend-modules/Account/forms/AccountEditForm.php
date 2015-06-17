<?php
/**
 * AccountEditForm.php
 * @author Revin Roman http://phptime.ru
 */

namespace backend\modules\Account\forms;

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
    public $new_password;
    public $new_password_app;

    public function init()
    {
        if (!($this->User instanceof \resources\User)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('account', 'Not specified user to edit.'));
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

            /** semantic validators */
            [['name', 'email'], 'required'],
            [['email'], 'email'],
            [['name', 'email'], 'filter', 'filter' => 'str_clean'],
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
            'name' => \Yii::t('account', 'Username'),
            'email' => \Yii::t('account', 'Email'),
            'new_password' => \Yii::t('account', 'New password'),
            'new_password_app' => \Yii::t('account', 'Approve new password'),
        ];
    }

    /**
     * @return array
     */
    public function formAction()
    {
        return ['/account/rest/edit'];
    }

    /**
     * @return bool
     */
    public function isNewAccount()
    {
        return $this->User->isNewRecord;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $User = $this->User;

        $User->name = $this->name;
        $User->email = $this->email;

        if ($User->isNewRecord) {
            $User->activated = \resources\User::NOT_ACTIVATED;
            $User->deleted = \resources\User::NOT_DELETED;
        }

        if (!empty($this->new_password)) {
            $User->password = $this->new_password;
        }

        $result = $User->validate() && $User->save();

        if ($User->hasErrors()) {
            $this->populateErrors($User, 'name');
        }

        if (AuthManager() instanceof \yii\rbac\DbManager) {
            AuthManager()->invalidateCache();
        }

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