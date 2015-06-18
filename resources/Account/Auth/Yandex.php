<?php
/**
 * Yandex.php
 * @author Revin Roman
 */

namespace resources\Account\Auth;

/**
 * Class Yandex
 * @package resources\Account\Auth
 */
class Yandex extends AbstractSocial
{

    /**
     * @return \resources\Account\Auth\queries\AccountYandexQuery
     */
    public static function find()
    {
        return new \resources\Account\Auth\queries\AccountYandexQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_yandex}}';
    }
}