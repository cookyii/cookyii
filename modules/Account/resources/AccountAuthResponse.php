<?php
/**
 * AccountAuthResponse.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;
use yii\helpers\Json;

/**
 * Class AccountAuthResponse
 * @package cookyii\modules\Account\resources
 *
 * @property integer $id
 * @property string $user_ip
 * @property integer $received_at
 * @property string $client
 * @property string $response
 * @property string $result
 */
class AccountAuthResponse extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['received_at'], 'integer'],
            [['client', 'response', 'result', 'user_ip'], 'string'],

            /** semantic validators */
            [['client', 'response', 'result'], 'required'],

            /** default values */
            [['received_at'], 'default', 'value' => time()],
            [['user_ip'], 'default', 'value' => Request()->userIP],
        ];
    }

    /**
     * @param \yii\authclient\ClientInterface $Client
     * @return static
     */
    public static function createLog(\yii\authclient\ClientInterface $Client)
    {
        $AuthResponse = new static;
        $AuthResponse->client = $Client->getId();

        $attributes = $Client->getUserAttributes();
        $AuthResponse->response = Json::encode($attributes);

        return $AuthResponse;
    }

    /**
     * @return \cookyii\modules\Account\resources\queries\AccountAuthResponseQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Account\resources\queries\AccountAuthResponseQuery::className(), [
                get_called_class(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_response}}';
    }
}