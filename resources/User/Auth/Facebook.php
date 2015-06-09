<?php
/**
 * Facebook.php
 * @author Revin Roman
 */

namespace resources\User\Auth;

/**
 * Class Facebook
 * @package resources\User\Auth
 */
class Facebook extends AbstractSocial
{

    /**
     * @return \resources\User\Auth\queries\UserFacebookQuery
     */
    public static function find()
    {
        return new \resources\User\Auth\queries\UserFacebookQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_auth_facebook}}';
    }
}