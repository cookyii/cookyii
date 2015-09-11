<?php
/**
 * Yandex.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\Account\Auth;

/**
 * Class Yandex
 * @package cookyii\modules\Account\resources\Account\Auth
 */
class Yandex extends AbstractSocial
{

    /**
     * @return \cookyii\modules\Account\resources\Account\Auth\queries\AccountYandexQuery
     */
    public static function find()
    {
        return new \cookyii\modules\Account\resources\Account\Auth\queries\AccountYandexQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_yandex}}';
    }
}