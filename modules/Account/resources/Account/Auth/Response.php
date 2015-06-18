<?php
/**
 * AuthResponse.php
 * @author Revin Roman
 */

namespace resources\Account\Auth;

/**
 * Class AuthResponse
 * @package resources\Account\Auth
 *
 * @property integer $id
 * @property integer $received_at
 * @property string $client
 * @property string $response
 * @property string $result
 * @property string $user_ip
 */
class Response extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['received_at', 'user_ip'], 'integer'],
            [['client', 'response', 'result'], 'string'],

            /** semantic validators */
            [['client', 'response', 'result'], 'required'],

            /** default values */
            [['received_at'], 'default', 'value' => time()],
            [['user_ip'], 'default', 'value' => ip2long(Request()->userIP)],
        ];
    }

    /**
     * @return \resources\Account\Auth\queries\AccountAuthResponseQuery
     */
    public static function find()
    {
        return new \resources\Account\Auth\queries\AccountAuthResponseQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_response}}';
    }
}