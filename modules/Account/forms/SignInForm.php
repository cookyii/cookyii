<?php
/**
 * SignInForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\forms;

use cookyii\Decorator as D;
use cookyii\modules\Account\resources\Account\Model as AccountModel;

/**
 * Class SignInForm
 * @package cookyii\modules\Account\forms
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
        /** @var AccountModel $AccountModel */
        $AccountModel = \Yii::createObject(AccountModel::class);

        return [
            /** type validators */
            [['email'], 'email'],
            [['remember'], 'boolean', 'trueValue' => 'true', 'falseValue' => 'false', 'strict' => true],

            /** semantic validators */
            [['email', 'password'], 'required',],
            [['email'], 'filter', 'filter' => 'str_clean'],
            [['email'], 'exist', 'targetClass' => get_class($AccountModel), 'targetAttribute' => 'email'],
            [['password'], 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('cookyii.account', 'Email'),
            'password' => \Yii::t('cookyii.account', 'Password'),
            'remember' => \Yii::t('cookyii.account', 'Remember me'),
        ];
    }

    /**
     * @return array
     */
    public function formAction()
    {
        return ['/account/api/in'];
    }

    /**
     * @param string $attribute
     */
    public function validatePassword($attribute)
    {
        $Account = $this->getAccount();
        if (!$Account || !$Account->validatePassword($this->$attribute)) {
            $this->addError($attribute, \Yii::t('cookyii.account', 'Account not found.'));
        }
    }

    /**
     * @return bool
     */
    public function login()
    {
        $Account = $this->getAccount();

        if (true === ($reason = $Account->isAvailable())) {
            return D::User()->login(
                $Account,
                $this->remember === 'true'
                    ? static::REMEMBER_TIME
                    : 0
            );
        } else {
            switch ($reason) {
                case 'deleted':
                    $this->addError('email', \Yii::t('cookyii.account', 'Account removed.'));
                    break;
                case 'not-activated':
                    $this->addError('email', \Yii::t('cookyii.account', 'Account is not activated.'));
                    break;
            }
        }

        return false;
    }

    private $_Account = null;

    /**
     * @return AccountModel
     */
    private function getAccount()
    {
        if ($this->_Account === null) {
            /** @var AccountModel $AccountModel */
            $AccountModel = \Yii::createObject(AccountModel::class);

            $this->_Account = $AccountModel::find()
                ->byEmail($this->email)
                ->one();
        }

        return $this->_Account;
    }
}