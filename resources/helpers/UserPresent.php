<?php
/**
 * UserPresent.php
 * @author Revin Roman
 */

namespace resources\helpers;

/**
 * Class UserPresent
 * @package resources\helpers
 *
 * @property string $avatar
 * @property string $created_at
 * @property string $updated_at
 */
class UserPresent extends \common\components\Presenter
{

    /** @var \resources\User */
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