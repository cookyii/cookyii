<?php
/**
 * ClientPresent.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\resources\helpers;

/**
 * Class ClientPresent
 * @package cookyii\modules\Client\resources\helpers
 *
 * @property string $avatar
 * @property string $created_at
 * @property string $updated_at
 */
class ClientPresent extends \cookyii\Presenter
{

    /** @var \cookyii\modules\Client\resources\Client */
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