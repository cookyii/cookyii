<?php
/**
 * AccountNotification.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\helpers;

/**
 * Class AccountNotification
 * @package cookyii\modules\Account\resources\helpers
 */
class AccountNotification extends \cookyii\helpers\AbstractNotificator
{

    /** @var \cookyii\modules\Account\resources\Account */
    public $Model;

    /**
     * @return array|bool
     * @throws \yii\web\ServerErrorHttpException
     */
    public function sendSignUpEmail($password =null)
    {
        $Account = $this->Model;

        $password = empty($password) ? $Account->password : $password;

        $Message = \cookyii\modules\Postman\resources\Postman\Message::create('account.frontend.sign-up', [
            '{user_id}' => $Account->id,
            '{username}' => $Account->name,
            '{email}' => $Account->email,
            '{password}' => $password,
        ]);

        $Message->addTo($Account->email, $Account->name);

        return $Message->send();
    }

    /**
     * @param string $hash
     * @return array|bool
     * @throws \yii\web\ServerErrorHttpException
     */
    public function sendNewPasswordRequestEmail($hash)
    {
        $Account = $this->Model;

        $url = UrlManager('frontend')->createAbsoluteUrl(['/account/forgot-password/check', 'email' => $Account->email, 'hash' => $hash]);
        $short_url = UrlManager('frontend')->createAbsoluteUrl(['/account/forgot-password/check', 'email' => $Account->email]);

        $Message = \cookyii\modules\Postman\resources\Postman\Message::create('account.frontend.forgot-password.request', [
            '{user_id}' => $Account->id,
            '{username}' => $Account->name,
            '{hash}' => $hash,
            '{url}' => $url,
            '{short_url}' => $short_url,
        ]);

        $Message->addTo($Account->email, $Account->name);

        return $Message->send();
    }

    /**
     * @param string $new_password
     * @return array|bool
     * @throws \yii\web\ServerErrorHttpException
     */
    public function sendNewPasswordEmail($new_password)
    {
        $Account = $this->Model;

        $Message = \cookyii\modules\Postman\resources\Postman\Message::create('account.frontend.forgot-password.new-password', [
            '{user_id}' => $Account->id,
            '{username}' => $Account->name,
            '{email}' => $Account->email,
            '{password}' => $new_password,
        ]);

        $Message->addTo($Account->email, $Account->name);

        return $Message->send();
    }

    /**
     * @return array|bool
     * @throws \yii\web\ServerErrorHttpException
     */
    public function sendBanEmail()
    {
        $Account = $this->Model;

        $Message = \cookyii\modules\Postman\resources\Postman\Message::create('account.frontend.ban', [
            '{user_id}' => $Account->id,
            '{username}' => $Account->name,
            '{email}' => $Account->email,
        ]);

        $Message->addTo($Account->email, $Account->name);

        return $Message->send();
    }

    /**
     * @return array|bool
     * @throws \yii\web\ServerErrorHttpException
     */
    public function sendUnBanEmail()
    {
        $Account = $this->Model;

        $Message = \cookyii\modules\Postman\resources\Postman\Message::create('account.frontend.unban', [
            '{user_id}' => $Account->id,
            '{username}' => $Account->name,
            '{email}' => $Account->email,
        ]);

        $Message->addTo($Account->email, $Account->name);

        return $Message->send();
    }
}