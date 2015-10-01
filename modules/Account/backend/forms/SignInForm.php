<?php
/**
 * SignInForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend\forms;

/**
 * Class SignInForm
 * @package cookyii\modules\Account\backend\forms
 */
class SignInForm extends \cookyii\base\FormModel
{

    public $email;
    public $password;
    public $remember;

    const REMEMBER_TIME = 864000; // 10 days

    /**
     * @inheritdoc
     */
    public function rules()
    {
        /** @var \cookyii\modules\Account\resources\Account $AccountModel */
        $AccountModel = \Yii::createObject(\cookyii\modules\Account\resources\Account::className());

        return [
            /** type validators */
            [['email'], 'email'],
            [['remember'], 'boolean', 'trueValue' => 'true', 'falseValue' => 'false', 'strict' => true],

            /** semantic validators */
            [['email', 'password'], 'required',],
            [['email'], 'filter', 'filter' => 'str_clean'],
            [['email'], 'exist', 'targetClass' => $AccountModel::className(), 'targetAttribute' => 'email'],
            [['password'], 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('account', 'Email'),
            'password' => \Yii::t('account', 'Password'),
            'remember' => \Yii::t('account', 'Remember me'),
        ];
    }

    /**
     * @return array
     */
    public function formAction()
    {
        return ['/account/rest/in'];
    }

    /**
     * @param string $attribute
     */
    public function validatePassword($attribute)
    {
        $Account = $this->getAccount();
        if (!$Account || !$Account->validatePassword($this->$attribute)) {
            $this->addError($attribute, \Yii::t('account', 'Account not found.'));
        }
    }

    /**
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            $Account = $this->getAccount();

            if (true === ($reason = $Account->isAvailable())) {
                return User()->login(
                    $Account,
                    $this->remember === 'true'
                        ? static::REMEMBER_TIME
                        : 0
                );
            } else {
                switch ($reason) {
                    case 'deleted':
                        $this->addError('email', \Yii::t('account', 'Account removed.'));
                        break;
                    case 'not-activated':
                        $this->addError('email', \Yii::t('account', 'Account is not activated.'));
                        break;
                }
            }
        }

        return false;
    }

    private $_Account = null;

    /**
     * @return \cookyii\modules\Account\resources\Account
     */
    private function getAccount()
    {
        if ($this->_Account === null) {
            /** @var \cookyii\modules\Account\resources\Account $AccountModel */
            $AccountModel = \Yii::createObject(\cookyii\modules\Account\resources\Account::className());

            $this->_Account = $AccountModel::find()
                ->byEmail($this->email)
                ->one();
        }

        return $this->_Account;
    }
}