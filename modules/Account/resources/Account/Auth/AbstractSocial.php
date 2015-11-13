<?php
/**
 * AbstractSocial.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\Account\Auth;

/**
 * Class AbstractSocial
 * @package cookyii\modules\Account\resources\Account\Auth
 *
 * @property integer $account_id
 * @property string $social_id
 * @property string $token
 */
abstract class AbstractSocial extends \yii\db\ActiveRecord
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
}