<?php
/**
 * AccountAuthGoogle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthGoogle
 * @package cookyii\modules\Account\resources
 */
class AccountAuthGoogle extends AbstractAccountAuth
{

    /**
     * @return \cookyii\modules\Account\resources\queries\AccountGoogleQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Account\resources\queries\AccountGoogleQuery::className(), [
                get_called_class(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_google}}';
    }
}