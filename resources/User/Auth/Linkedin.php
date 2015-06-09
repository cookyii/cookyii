<?php
/**
 * Linkedin.php
 * @author Revin Roman
 */

namespace resources\User\Auth;

/**
 * Class Linkedin
 * @package resources\User\Auth
 */
class Linkedin extends AbstractSocial
{

    /**
     * @return \resources\User\Auth\queries\UserLinkedinQuery
     */
    public static function find()
    {
        return new \resources\User\Auth\queries\UserLinkedinQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_auth_linkedin}}';
    }
}