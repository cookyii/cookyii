<?php
/**
 * AccountEditForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend\forms;

/**
 * Class AccountEditForm
 * @package cookyii\modules\Account\backend\forms
 */
class AccountEditForm extends \cookyii\base\FormModel
{

    use \cookyii\db\traits\PopulateErrorsTrait;

    /** @var \cookyii\modules\Account\resources\Account */
    public $Account;

    public $name;
    public $email;
    public $new_password;
    public $new_password_app;

    public function init()
    {
        if (!($this->Account instanceof \cookyii\modules\Account\resources\Account)) {
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
     * @return bool
     */
    public function save()
    {
        $Account = $this->Account;

        $Account->name = $this->name;
        $Account->email = $this->email;

        if (!empty($this->new_password)) {
            $Account->password = $this->new_password;
        }

        $result = $Account->validate() && $Account->save();

        if ($Account->hasErrors()) {
            $this->populateErrors($Account, 'name');
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