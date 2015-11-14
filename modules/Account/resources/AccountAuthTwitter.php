<?php
/**
 * AccountAuthTwitter.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthTwitter
 * @package cookyii\modules\Account\resources
 */
class AccountAuthTwitter extends AbstractAccountAuth
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_twitter}}';
    }
}