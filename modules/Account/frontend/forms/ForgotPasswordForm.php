<?php
/**
 * ForgotPasswordForm.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\frontend\forms;

use yii\helpers\Json;

/**
 * Class ForgotPasswordForm
 * @package cookyii\modules\Account\frontend\forms
 */
class ForgotPasswordForm extends \yii\base\Model
{

    public $email;

    public $hash;

    public $loginAfterReset = true;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['email'], 'email'],

            /** semantic validators */
            [['email'], 'required',],
            [['email'], 'filter', 'filter' => 'str_clean'],
            [
                ['email'],
                'exist',
                'targetClass' => \resources\Account::className(),
                'targetAttribute' => 'email',
                'message' => \Yii::t('account', '{attribute} not found.'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('account', 'Email'),
        ];
    }

    /**
     * @return array
     */
    public function formAction()
    {
        return ['/account/rest/forgot-password'];
    }

    /**
     * @return bool
     */
    public function validateHash()
    {
        $Account = $this->getAccount();

        $data = $this->decryptData($Account);

        if (empty($data) || !isset($data['t']) || !isset($data['i']) || !isset($data['e'])) {
            $this->addError('hash', 'Invalid hash.');
        }

        $delta = time() - $data['t'];

        if ($delta > 3600 * 24) {
            $this->addError('hash', 'Hash outdated.');
        }

        if ($Account->email !== $data['e']) {
            $this->addError('hash', 'Invalid hash.');
        }

        return !$this->hasErrors();
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

        if ($Account->hasErrors()) {
            $this->addError('email', array_shift($Account->getFirstErrors()));
        } else {
            $Message = \resources\Postman\Message::create('account.frontend.forgot-password.new-password', [
                '{user_id}' => $Account->id,
                '{username}' => $Account->name,
                '{email}' => $Account->email,
                '{password}' => $new_password,
            ]);

            $Message->addTo($Account->email, $Account->name);

            $Message->send();

            if ($this->loginAfterReset) {
                User()->login($Account, SignInForm::REMEMBER_TIME);
            }
        }

        return !$Account->hasErrors();
    }

    /**
     * @param \resources\Account $Account
     * @return string
     */
    private function encryptData($Account)
    {
        $data = Json::encode([
            't' => time(),
            'i' => $Account->id,
            'e' => $Account->email,
        ]);

        return base64_encode(Security()->encryptByKey($data, $Account->getEncryptKey()));
    }

    /**
     * @param \resources\Account $Account
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

                $url = UrlManager('frontend')->createAbsoluteUrl(['/account/forgot-password/check', 'email' => $Account->email, 'hash' => $hash]);

                $Message = \resources\Postman\Message::create('account.frontend.forgot-password.request', [
                    '{user_id}' => $Account->id,
                    '{username}' => $Account->name,
                    '{hash}' => $hash,
                    '{url}' => $url,
                ]);

                $Message->addTo($Account->email, $Account->name);

                return $Message->send();
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
     * @return \resources\Account
     */
    private function getAccount()
    {
        if ($this->_Account === null) {
            $this->_Account = \resources\Account::find()
                ->byEmail($this->email)
                ->one();
        }

        return $this->_Account;
    }
}