<?php
/**
 * AccountAuthVkontakte.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthVkontakte
 * @package cookyii\modules\Account\resources
 */
class AccountAuthVkontakte extends AbstractAccountAuth
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_vkontakte}}';
    }
}