<?php
/**
 * Yandex.php
 * @author Revin Roman
 */

namespace resources\User\Auth;

/**
 * Class Yandex
 * @package resources\User\Auth
 */
class Yandex extends AbstractSocial
{

    /**
     * @return \resources\User\Auth\queries\UserYandexQuery
     */
    public static function find()
    {
        return new \resources\User\Auth\queries\UserYandexQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_auth_yandex}}';
    }
}