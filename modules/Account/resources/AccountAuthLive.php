<?php
/**
 * AccountAuthLive.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthLive
 * @package cookyii\modules\Account\resources
 */
class AccountAuthLive extends AbstractAccountAuth
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_live}}';
    }
}