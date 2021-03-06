<?php
/**
 * SignUpForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\forms;

use cookyii\Facade as F;
use cookyii\modules\Account;
use cookyii\modules\Account\resources\Account\Model as AccountModel;
use cookyii\traits\PopulateErrorsTrait;
use rmrevin\yii\rbac\RbacFactory;

/**
 * Class SignUpForm
 * @package cookyii\modules\Account\forms
 */
class SignUpForm extends \cookyii\base\FormModel
{

    use PopulateErrorsTrait;

    public $name;
    public $email;
    public $password;
    public $password_app;

    public $agree;

    public $loginAfterRegister = true;

    public $accountModule = 'account';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        /** @var AccountModel $AccountModel */
        $AccountModel = \Yii::createObject(AccountModel::class);

        return [
            /** type validators */
            [['email'], 'email'],
            [['name', 'email', 'password', 'password'], 'string'],
            [['agree'], 'boolean', 'trueValue' => 'true', 'falseValue' => 'false'],

            /** semantic validators */
            [['name', 'email', 'password', 'password_app'], 'required'],
            [['name', 'email'], 'filter', 'filter' => 'str_clean'],
            [['email'], 'unique', 'targetClass' => get_class($AccountModel), 'targetAttribute' => 'email'],
            [['password_app'], 'compare', 'compareAttribute' => 'password'],
            [['agree'], 'compare', 'compareValue' => 'true', 'operator' => '===', 'message' => \Yii::t('cookyii.account', 'You must accept the terms')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('cookyii.account', 'Name'),
            'email' => \Yii::t('cookyii.account', 'Email'),
            'password' => \Yii::t('cookyii.account', 'Password'),
            'password_app' => \Yii::t('cookyii.account', 'Password approve'),
            'agree' => \Yii::t('cookyii.account', 'I agree to the terms of use'),
        ];
    }

    /**
     * @return array
     */
    public function formAction()
    {
        return ['/account/api/up'];
    }

    /**
     * @return bool
     */
    public function register()
    {
        /** @var Account\backend\Module $Module */
        $Module = \Yii::$app->getModule($this->accountModule);
        $roles = $Module->roles;

        /** @var AccountModel $Account */
        $Account = \Yii::createObject(AccountModel::class);
        $Account->setAttributes([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'activated_at' => time(),
        ]);

        $Account->validate() && $Account->save();

        if (!$Account->hasErrors()) {
            $Account->notificationHelper
                ->sendSignUpEmail();

            F::AuthManager()->assign(RbacFactory::Role($roles['user']), $Account->id);

            if ($this->loginAfterRegister) {
                $SignInFormModel = \Yii::createObject(SignInForm::class);

                F::User()->login($Account, $SignInFormModel::REMEMBER_TIME);
            }
        }

        if ($Account->hasErrors()) {
            $this->populateErrors($Account, 'name');
        }

        return !$Account->hasErrors();
    }
}