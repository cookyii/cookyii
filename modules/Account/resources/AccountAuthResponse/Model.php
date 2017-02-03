<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\AccountAuthResponse;

use cookyii\Facade as F;
use yii\helpers\Json;

/**
 * Class Model
 * @package cookyii\modules\Account\resources\AccountAuthResponse
 *
 * @property integer $id
 * @property string $user_ip
 * @property integer $received_at
 * @property string $client
 * @property string $response
 * @property string $result
 */
class Model extends \cookyii\db\ActiveRecord
{

    static $tableName = '{{%account_auth_response}}';

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
            [['user_ip'], 'default', 'value' => F::Request()->userIP],
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
     * @return Query
     */
    public static function find()
    {
        return \Yii::createObject(Query::class, [get_called_class()]);
    }
}
