<?php
/**
 * Vkontakte.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\Account\Auth;

/**
 * Class Vkontakte
 * @package cookyii\modules\Account\resources\Account\Auth
 */
class Vkontakte extends AbstractSocial
{

    /**
     * @return \cookyii\modules\Account\resources\Account\Auth\queries\AccountVkontakteQuery
     */
    public static function find()
    {
        return new \cookyii\modules\Account\resources\Account\Auth\queries\AccountVkontakteQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_vkontakte}}';
    }
}