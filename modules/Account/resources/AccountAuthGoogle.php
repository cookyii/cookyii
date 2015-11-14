<?php
/**
 * AccountAuthGoogle.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthGoogle
 * @package cookyii\modules\Account\resources
 */
class AccountAuthGoogle extends AbstractAccountAuth
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_google}}';
    }
}