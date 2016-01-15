<?php
/**
 * AccountAuth.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuth
 * @package cookyii\modules\Account\resources
 *
 * @property string $social_type
 * @property string $social_id
 * @property integer $account_id
 * @property string $token
 */
class AccountAuth extends \yii\db\ActiveRecord
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