<?php
/**
 * Facebook.php
 * @author Revin Roman
 */

namespace resources\Account\Auth;

/**
 * Class Facebook
 * @package resources\Account\Auth
 */
class Facebook extends AbstractSocial
{

    /**
     * @return \resources\Account\Auth\queries\AccountFacebookQuery
     */
    public static function find()
    {
        return new \resources\Account\Auth\queries\AccountFacebookQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_facebook}}';
    }
}