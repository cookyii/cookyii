<?php
/**
 * AbstractSocial.php
 * @author Revin Roman
 */

namespace resources\User\Auth;

/**
 * Class AbstractSocial
 * @package resources\User\Auth
 *
 * @property integer $user_id
 * @property string $social_id
 */
abstract class AbstractSocial extends \yii\db\ActiveRecord
{

}