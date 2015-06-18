<?php
/**
 * Vkontakte.php
 * @author Revin Roman
 */

namespace resources\Account\Auth;

/**
 * Class Vkontakte
 * @package resources\Account\Auth
 */
class Vkontakte extends AbstractSocial
{

    /**
     * @return \resources\Account\Auth\queries\AccountVkontakteQuery
     */
    public static function find()
    {
        return new \resources\Account\Auth\queries\AccountVkontakteQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_vkontakte}}';
    }
}