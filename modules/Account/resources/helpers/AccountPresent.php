<?php
/**
 * AccountPresent.php
 * @author Revin Roman
 */

namespace resources\helpers;

/**
 * Class AccountPresent
 * @package resources\helpers
 *
 * @property string $avatar
 * @property string $created_at
 * @property string $updated_at
 */
class AccountPresent extends \cookyii\Presenter
{

    /** @var \cookyii\modules\Account\resources\Account */
    public $Model;

    /**
     * @param integer $size
     * @return string
     */
    public function getAvatar($size = 80)
    {
        return gravatar($this->Model->email, $size);
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return Formatter()->asRelativeTime($this->Model->created_at);
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return Formatter()->asRelativeTime($this->Model->updated_at);
    }
}