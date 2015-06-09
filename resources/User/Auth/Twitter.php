<?php
/**
 * Twitter.php
 * @author Revin Roman
 */

namespace resources\User\Auth;

/**
 * Class Twitter
 * @package resources\User\Auth
 */
class Twitter extends AbstractSocial
{

    /**
     * @return \resources\User\Auth\queries\UserTwitterQuery
     */
    public static function find()
    {
        return new \resources\User\Auth\queries\UserTwitterQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_auth_twitter}}';
    }
}