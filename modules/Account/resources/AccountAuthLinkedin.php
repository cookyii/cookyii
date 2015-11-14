<?php
/**
 * AccountAuthLinkedin.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthLinkedin
 * @package cookyii\modules\Account\resources
 */
class AccountAuthLinkedin extends AbstractAccountAuth
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_linkedin}}';
    }
}