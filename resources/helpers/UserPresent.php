<?php
/**
 * UserPresent.php
 * @author Revin Roman http://phptime.ru
 */

namespace resources\helpers;

/**
 * Class UserPresent
 * @package resources\helpers
 *
 * @property string $created_at
 * @property string $updated_at
 */
class UserPresent extends \common\components\Presenter
{

    /** @var \resources\User */
    public $Model;

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