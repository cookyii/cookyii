<?php
/**
 * ForgotPasswordForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\forms;

use cookyii\modules\Account\resources\Account\Model as AccountModel;
use yii\helpers\Json;

/**
 * Class ForgotPasswordForm
 * @package cookyii\modules\Account\forms
 */
class ForgotPasswordForm extends \cookyii\base\FormModel
{

    use \cookyii\traits\PopulateErrorsTrait;

    public $email;

    public $hash;

    public $loginAfterReset = true;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        /** @var AccountModel $AccountModel */
        $AccountModel = \Yii::createObject(AccountModel::className());

        return [
            /** type validators */
            [['email'], 'email'],

            /** semantic validators */
            [['email'], 'required',],
            [['email'], 'filter', 'filter' => 'str_clean'],
            [
                ['email'],
                'exist',
                'targetClass' => $AccountModel::className(),
                'targetAttribute' => 'email',
                'message' => \Yii::t('cookyii.account', '{attribute} not found.'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('cookyii.account', 'Email'),
        ];
    }

    /**
     * @return array
     */
    public function formAction()
    {
        return ['/account/api/forgot-password'];
    }

    /**
     * @return bool
     */
    public function validateHash()
    {
        $Account = $this->getAccount();

        $data = $this->decryptData($Account);

        if (empty($data) || !isset($data['t']) || !isset($data['i']) || !isset($data['e']) || !isset($data['s'])) {
            $this->addError('hash', 'Invalid hash.');
        }

        $delta = time() - $data['t'];

        if ($delta > 3600 * 24) {
            $this->addError('hash', 'Hash outdated.');
        }

        if ($Account->email !== $data['e']) {
            $this->addError('hash', 'Invalid hash.');
        }

        if ($Account->token !== $data['s']) {
            $this->addError('hash', 'Invalid hash.');
        }

        return !$this->hasErrors();
    }

    /**
     * @return array|bool
     * @throws \yii\web\ServerErrorHttpException
     */
    public function sendNotification()
    {
        if ($this->validate()) {
            $Account = $this->getAccount();

            if (true === ($reason = $Account->isAvailable())) {
                $hash = $this->encryptData($Account);

                return $Account->notificationHelper
                    ->sendNewPasswordRequestEmail($hash);
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
        }

        return false;
    }

    /**
     * @return bool
     * @throws \yii\web\ServerErrorHttpException
     */
    public function resetPassword()
    {
        $Account = $this->getAccount();

        $new_password = Security()->generateRandomString(8);

        $Account->password = $new_password;

        $Account->validate() && $Account->save();

        if (!$Account->hasErrors()) {
            $Account->notificationHelper
                ->sendNewPasswordEmail($new_password);

            $Account->refreshToken();

            if ($this->loginAfterReset) {
                $SignInFormModel = \Yii::createObject(SignInForm::className());

                User()->login($Account, $SignInFormModel::REMEMBER_TIME);
            }
        }

        if ($Account->hasErrors()) {
            $this->populateErrors($Account, 'email');
        }

        return !$Account->hasErrors();
    }

    private $_Account = null;

    /**
     * @return AccountModel
     */
    private function getAccount()
    {
        if ($this->_Account === null) {
            /** @var AccountModel $AccountModel */
            $AccountModel = \Yii::createObject(AccountModel::className());

            $this->_Account = $AccountModel::find()
                ->byEmail($this->email)
                ->one();
        }

        return $this->_Account;
    }

    /**
     * @param AccountModel $Account
     * @return string
     */
    private function encryptData($Account)
    {
        $data = Json::encode([
            't' => time(),
            'i' => $Account->id,
            'e' => $Account->email,
            's' => $Account->token,
        ]);

        return base64_encode(Security()->encryptByKey($data, $Account->getEncryptKey()));
    }

    /**
     * @param AccountModel $Account
     * @return array
     */
    private function decryptData($Account)
    {
        if (empty($this->hash)) {
            throw new \yii\base\InvalidParamException('Empty hash.');
        }

        $data = Security()->decryptByKey(base64_decode($this->hash), $Account->getEncryptKey());

        if (empty($data)) {
            throw new \yii\base\InvalidParamException('Invalid hash.');
        }

        return Json::decode($data);
    }
}