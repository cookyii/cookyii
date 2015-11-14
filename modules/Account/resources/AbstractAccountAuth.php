<?php
/**
 * AbstractAccountAuth.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AbstractAccountAuth
 * @package cookyii\modules\Account\resources
 *
 * @property integer $account_id
 * @property string $social_id
 * @property string $token
 */
abstract class AbstractAccountAuth extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['social_id', 'token'], 'string'],
            [['account_id'], 'integer'],

            /** semantic validators */
            [['account_id', 'social_id'], 'required'],

            /** default values */
        ];
    }

    /**
     * @param string|integer $account_id
     */
    public static function remove($account_id)
    {
        static::deleteAll([
            'account_id' => $account_id,
        ]);
    }

    /**
     * @return array
     */
    public static function getClientsList()
    {
        $base = [
            'facebook' => \cookyii\modules\Account\resources\AccountAuthFacebook::className(),
            'github' => \cookyii\modules\Account\resources\AccountAuthGithub::className(),
            'google' => \cookyii\modules\Account\resources\AccountAuthGoogle::className(),
            'linkedin' => \cookyii\modules\Account\resources\AccountAuthLinkedin::className(),
            'live' => \cookyii\modules\Account\resources\AccountAuthLive::className(),
            'twitter' => \cookyii\modules\Account\resources\AccountAuthTwitter::className(),
            'vkontakte' => \cookyii\modules\Account\resources\AccountAuthVkontakte::className(),
            'yandex' => \cookyii\modules\Account\resources\AccountAuthYandex::className(),
        ];

        $result = [];

        // extract di
        foreach ($base as $name => $class) {
            /** @var \cookyii\modules\Account\resources\AbstractAccountAuth $Auth */
            $Auth = \Yii::createObject($class);

            $result[$name] = $Auth::className();
        }

        return $result;
    }
}