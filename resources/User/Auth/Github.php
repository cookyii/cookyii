<?php
/**
 * Github.php
 * @author Revin Roman
 */

namespace resources\User\Auth;

/**
 * Class Github
 * @package resources\User\Auth
 */
class Github extends AbstractSocial
{

    /**
     * @return \resources\User\Auth\queries\UserGithubQuery
     */
    public static function find()
    {
        return new \resources\User\Auth\queries\UserGithubQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_auth_github}}';
    }
}