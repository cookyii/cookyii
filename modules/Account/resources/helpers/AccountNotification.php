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
     * @param string $template_code
     * @param array $placeholders
     * @param null $subject
     * @param string $styles
     * @return \cookyii\modules\Postman\resources\PostmanMessage
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ServerErrorHttpException
     */
    protected function createMessage($template_code, $placeholders = [], $subject = null, $styles = '')
    {
        /** @var \cookyii\modules\Postman\resources\PostmanMessage $MessageModel */
        $MessageModel = \Yii::createObject(\cookyii\modules\Postman\resources\PostmanMessage::className());

        $Message = $MessageModel::create($template_code, $placeholders, $subject, $styles);

        unset($MessageModel);

        return $Message;
    }

    /**
     * @param null|string $password
     * @return array|bool
     * @throws \yii\web\ServerErrorHttpException
     */
    public function sendSignUpEmail($password = null)
    {
        $Account = $this->Model;

        $password = empty($password) ? $Account->password : $password;

        $Message = $this->createMessage('account.frontend.sign-up', [
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

        $url = UrlManager()->createAbsoluteUrl(['/account/forgot-password/check', 'email' => $Account->email, 'hash' => $hash]);
        $short_url = UrlManager()->createAbsoluteUrl(['/account/forgot-password/check', 'email' => $Account->email]);

        $Message = $this->createMessage('account.frontend.forgot-password.request', [
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

        $Message = $this->createMessage('account.frontend.forgot-password.new-password', [
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

        $Message = $this->createMessage('account.frontend.ban', [
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

        $Message = $this->createMessage('account.frontend.unban', [
            '{user_id}' => $Account->id,
            '{username}' => $Account->name,
            '{email}' => $Account->email,
        ]);

        $Message->addTo($Account->email, $Account->name);

        return $Message->send();
    }
}