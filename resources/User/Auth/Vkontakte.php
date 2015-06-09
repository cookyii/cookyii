<?php
/**
 * Vkontakte.php
 * @author Revin Roman
 */

namespace resources\User\Auth;

/**
 * Class Vkontakte
 * @package resources\User\Auth
 */
class Vkontakte extends AbstractSocial
{

    /**
     * @return \resources\User\Auth\queries\UserVkontakteQuery
     */
    public static function find()
    {
        return new \resources\User\Auth\queries\UserVkontakteQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_auth_vkontakte}}';
    }
}