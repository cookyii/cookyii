<?php
/**
 * AccountAuthFacebook.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthFacebook
 * @package cookyii\modules\Account\resources
 */
class AccountAuthFacebook extends AbstractAccountAuth
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_facebook}}';
    }
}