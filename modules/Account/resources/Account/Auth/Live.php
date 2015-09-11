<?php
/**
 * Live.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\resources\Account\Auth;

/**
 * Class Live
 * @package cookyii\modules\Account\resources\Account\Auth
 */
class Live extends AbstractSocial
{

    /**
     * @return \cookyii\modules\Account\resources\Account\Auth\queries\AccountLiveQuery
     */
    public static function find()
    {
        return new \cookyii\modules\Account\resources\Account\Auth\queries\AccountLiveQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_live}}';
    }
}