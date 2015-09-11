<?php
/**
 * Linkedin.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\Account\Auth;

/**
 * Class Linkedin
 * @package cookyii\modules\Account\resources\Account\Auth
 */
class Linkedin extends AbstractSocial
{

    /**
     * @return \cookyii\modules\Account\resources\Account\Auth\queries\AccountLinkedinQuery
     */
    public static function find()
    {
        return new \cookyii\modules\Account\resources\Account\Auth\queries\AccountLinkedinQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_linkedin}}';
    }
}