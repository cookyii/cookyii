<?php
/**
 * AccountPresent.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\helpers;

/**
 * Class AccountPresent
 * @package cookyii\modules\Account\resources\helpers
 *
 * @property \cookyii\modules\Account\resources\Account $Model
 * 
 * @property string $avatar
 */
class AccountPresent extends \cookyii\db\helpers\AbstractHelper
{

    /**
     * @param integer $size
     * @return string
     */
    public function getAvatar($size = 80)
    {
        return gravatar($this->Model->email, $size);
    }
}
