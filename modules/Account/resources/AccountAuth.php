<?php
/**
 * AccountAuth.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

use yii\helpers\Json;

/**
 * Class AccountAuth
 * @package cookyii\modules\Account\resources
 *
 * @property string $social_type
 * @property string $social_id
 * @property integer $account_id
 * @property string $token
 *
 * @property \yii\authclient\OAuthToken $accessToken
 */
class AccountAuth extends \cookyii\db\ActiveRecord
{

    static $providers = ['facebook', 'github', 'google', 'linkedin', 'live', 'twitter', 'vkontakte', 'yandex'];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['social_type', 'social_id', 'token'], 'string'],
            [['account_id'], 'integer'],

            /** semantic validators */
            [['social_type', 'social_id', 'account_id'], 'required'],

            /** default values */
        ];
    }

    /**
     * @return \yii\authclient\OAuthToken
     */
    public function getAccessToken()
    {
        $token = Json::decode($this->token);

        return new \yii\authclient\OAuthToken($token);
    }

    /**
     * @param integer $account_id
     * @param string $social_type
     * @param integer|string $social_id
     * @param array|null $token
     * @return static
     */
    public static function push($account_id, $social_type, $social_id, $token = null)
    {
        /** @var static $Auth */
        $Auth = static::find()
            ->byAccountId($account_id)
            ->bySocialType($social_type)
            ->bySocialId($social_id)
            ->one();

        if (empty($Auth)) {
            $Auth = new static;

            $Auth->setAttributes([
                'account_id' => $account_id,
                'social_type' => $social_type,
                'social_id' => $social_id,
            ]);
        }

        if (!empty($token)) {
            $Auth->token = Json::encode($token);
        }

        $Auth->validate() && $Auth->save(false);

        return $Auth;
    }

    /**
     * @return \cookyii\modules\Account\resources\queries\AccountAuthQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Account\resources\queries\AccountAuthQuery::className(), [
                get_called_class(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth}}';
    }
}
