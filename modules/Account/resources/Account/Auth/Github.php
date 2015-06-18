<?php
/**
 * Github.php
 * @author Revin Roman
 */

namespace resources\Account\Auth;

/**
 * Class Github
 * @package resources\Account\Auth
 */
class Github extends AbstractSocial
{

    /**
     * @return \resources\Account\Auth\queries\AccountGithubQuery
     */
    public static function find()
    {
        return new \resources\Account\Auth\queries\AccountGithubQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_github}}';
    }
}