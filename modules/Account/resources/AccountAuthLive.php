<?php
/**
 * AccountAuthLive.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthLive
 * @package cookyii\modules\Account\resources
 */
class AccountAuthLive extends AbstractSocial
{

    /**
     * @return \cookyii\modules\Account\resources\queries\AccountLiveQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Account\resources\queries\AccountLiveQuery::className(), [
                get_called_class(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_live}}';
    }
}