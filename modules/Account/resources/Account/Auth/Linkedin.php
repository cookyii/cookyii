<?php
/**
 * Linkedin.php
 * @author Revin Roman
 */

namespace resources\Account\Auth;

/**
 * Class Linkedin
 * @package resources\Account\Auth
 */
class Linkedin extends AbstractSocial
{

    /**
     * @return \resources\Account\Auth\queries\AccountLinkedinQuery
     */
    public static function find()
    {
        return new \resources\Account\Auth\queries\AccountLinkedinQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_linkedin}}';
    }
}