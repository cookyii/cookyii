<?php
/**
 * Google.php
 * @author Revin Roman
 */

namespace resources\Account\Auth;

/**
 * Class Google
 * @package resources\Account\Auth
 */
class Google extends AbstractSocial
{

    /**
     * @return \resources\Account\Auth\queries\AccountGoogleQuery
     */
    public static function find()
    {
        return new \resources\Account\Auth\queries\AccountGoogleQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_google}}';
    }
}