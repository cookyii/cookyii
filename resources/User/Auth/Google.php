<?php
/**
 * Google.php
 * @author Revin Roman
 */

namespace resources\User\Auth;

/**
 * Class Google
 * @package resources\User\Auth
 */
class Google extends AbstractSocial
{

    /**
     * @return \resources\User\Auth\queries\UserGoogleQuery
     */
    public static function find()
    {
        return new \resources\User\Auth\queries\UserGoogleQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_auth_google}}';
    }
}