<?php
/**
 * ClientAccount.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\resources\helpers;

use cookyii\modules\Account;

/**
 * Class ClientAccount
 * @package cookyii\modules\Client\resources\helpers
 */
class ClientAccount extends \yii\base\Object
{

    /** @var \cookyii\modules\Client\resources\Client */
    public $Model;

    /**
     * @param null|string $name
     * @param null|string $email
     * @param null|string $password
     * @return \cookyii\modules\Account\resources\Account
     * @throws \yii\base\Exception
     */
    public function create($name = null, $email = null, $password = null)
    {
        $Client = $this->Model;

        if ($Client->isNewRecord) {
            throw new \yii\base\Exception(\Yii::t('client', 'You can not create an account from unsaved client.'));
        }

        $name = empty($name) ? $Client->name : $name;
        $email = empty($email) ? $Client->email : $email;
        $password = empty($password) ? Security()->generateRandomString(10) : $password;

        $Account = Account\resources\Account::find()
            ->byEmail($email)
            ->one();

        if (empty($Account)) {
            $Account = new Account\resources\Account;
            $Account->setAttributes([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'activated_at' => time(),
            ]);

            $Account->validate() && $Account->save();
        }

        if (!$Account->hasErrors() && !$Account->isNewRecord) {
            $Client->account_id = $Account->id;
            $Client->validate() && $Client->save();
        }

        return $Account;
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function unlink()
    {
        $Client = $this->Model;

        if (empty($Client->account_id)) {
            throw new \yii\base\Exception(\Yii::t('client', 'No bound Account'));
        }

        $Client->account_id = null;

        return $Client->validate() && $Client->save();
    }
}