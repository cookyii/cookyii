<?php
/**
 * AccountAuthTwitter.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthTwitter
 * @package cookyii\modules\Account\resources
 */
class AccountAuthTwitter extends AbstractAccountAuth
{

    /**
     * @return \cookyii\modules\Account\resources\queries\AccountTwitterQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Account\resources\queries\AccountTwitterQuery::className(), [
                get_called_class(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_twitter}}';
    }
}