<?php
/**
 * AccountAuthYandex.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthYandex
 * @package cookyii\modules\Account\resources
 */
class AccountAuthYandex extends AbstractAccountAuth
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_yandex}}';
    }
}