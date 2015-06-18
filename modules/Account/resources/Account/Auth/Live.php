<?php
/**
 * Live.php
 * @author Revin Roman
 */

namespace resources\Account\Auth;

/**
 * Class Live
 * @package resources\Account\Auth
 */
class Live extends AbstractSocial
{

    /**
     * @return \resources\Account\Auth\queries\AccountLiveQuery
     */
    public static function find()
    {
        return new \resources\Account\Auth\queries\AccountLiveQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_live}}';
    }
}