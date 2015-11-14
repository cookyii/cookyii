<?php
/**
 * AccountAuthGithub.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthGithub
 * @package cookyii\modules\Account\resources
 */
class AccountAuthGithub extends AbstractAccountAuth
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_github}}';
    }
}