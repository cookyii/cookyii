<?php
/**
 * Live.php
 * @author Revin Roman
 */

namespace resources\User\Auth;

/**
 * Class Live
 * @package resources\User\Auth
 */
class Live extends AbstractSocial
{

    /**
     * @return \resources\User\Auth\queries\UserLiveQuery
     */
    public static function find()
    {
        return new \resources\User\Auth\queries\UserLiveQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_auth_live}}';
    }
}