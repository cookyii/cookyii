<?php
/**
 * Twitter.php
 * @author Revin Roman
 */

namespace resources\Account\Auth;

/**
 * Class Twitter
 * @package resources\Account\Auth
 */
class Twitter extends AbstractSocial
{

    /**
     * @return \resources\Account\Auth\queries\AccountTwitterQuery
     */
    public static function find()
    {
        return new \resources\Account\Auth\queries\AccountTwitterQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_twitter}}';
    }
}