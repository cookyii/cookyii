<?php
/**
 * AccountHelper.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\resources\Client\helpers;

use cookyii\Decorator as D;
use cookyii\modules\Account\resources\Account\Model as AccountModel;

/**
 * Class AccountHelper
 * @package cookyii\modules\Client\resources\Client\helpers
 *
 * @property \cookyii\modules\Client\resources\Client\Model $Model
 */
class AccountHelper extends \cookyii\db\helpers\AbstractHelper
{

    /**
     * @param null|string $name
     * @param null|string $email
     * @param null|string $password
     * @return AccountModel
     * @throws \yii\base\Exception
     */
    public function create($name = null, $email = null, $password = null)
    {
        $Client = $this->Model;

        if ($Client->isNewRecord) {
            throw new \yii\base\Exception(\Yii::t('cookyii.client', 'You can not create an account from unsaved client.'));
        }

        $name = empty($name) ? $Client->name : $name;
        $email = empty($email) ? $Client->email : $email;
        $password = empty($password) ? D::Security()->generateRandomString(10) : $password;

        /** @var AccountModel $AccountModel */
        $AccountModel = \Yii::createObject(AccountModel::class);

        $Account = $AccountModel::find()
            ->byEmail($email)
            ->one();

        if (empty($Account)) {
            $Account = $AccountModel;
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
            throw new \yii\base\Exception(\Yii::t('cookyii.client', 'No bound Account'));
        }

        $Client->account_id = null;

        return $Client->validate() && $Client->save();
    }
}
