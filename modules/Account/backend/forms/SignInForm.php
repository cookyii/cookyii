<?php
/**
 * SignInForm.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\backend\forms;

/**
 * Class SignInForm
 * @package cookyii\modules\Account\backend\forms
 */
class SignInForm extends \yii\base\Model
{

    public $email;
    public $password;
    public $remember;

    private $_User = null;

    const REMEMBER_TIME = 864000; // 10 days

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['email'], 'email'],
            [['remember'], 'boolean', 'trueValue' => 'true', 'falseValue' => 'false', 'strict' => true],

            /** semantic validators */
            [['email', 'password'], 'required',],
            [['email'], 'filter', 'filter' => 'str_clean'],
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
        $User = $this->getUser();
        if (!$User || !$User->validatePassword($this->$attribute)) {
            $this->addError($attribute, \Yii::t('account', 'Account not found.'));
        }
    }

    /**
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            $User = $this->getUser();

            if (true === ($reason = $User->isAvailable())) {
                return User()->login(
                    $User,
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

    /**
     * @return \resources\User
     */
    private function getUser()
    {
        if ($this->_User === null) {
            $this->_User = \resources\User::find()
                ->byEmail($this->email)
                ->one();
        }

        return $this->_User;
    }
}