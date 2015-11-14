<?php
/**
 * AccountAuthFacebook.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthFacebook
 * @package cookyii\modules\Account\resources
 */
class AccountAuthFacebook extends AbstractSocial
{

    /**
     * @return \cookyii\modules\Account\resources\queries\AccountFacebookQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Account\resources\queries\AccountFacebookQuery::className(), [
                get_called_class(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_facebook}}';
    }
}