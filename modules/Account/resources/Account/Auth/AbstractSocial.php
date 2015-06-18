<?php
/**
 * AbstractSocial.php
 * @author Revin Roman
 */

namespace resources\Account\Auth;

/**
 * Class AbstractSocial
 * @package resources\Account\Auth
 *
 * @property integer $account_id
 * @property string $social_id
 */
abstract class AbstractSocial extends \yii\db\ActiveRecord
{

}