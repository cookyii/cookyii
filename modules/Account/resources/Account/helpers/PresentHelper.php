<?php
/**
 * PresentHelper.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\Account\helpers;

/**
 * Class PresentHelper
 * @package cookyii\modules\Account\resources\Account\helpers
 *
 * @property \cookyii\modules\Account\resources\Account\Model $Model
 * 
 * @property string $avatar
 */
class PresentHelper extends \cookyii\db\helpers\AbstractHelper
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
