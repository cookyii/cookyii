<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace resources\Media;

/**
 * Class Model
 * @package resources\Media
 */
class Model extends \cookyii\modules\Media\resources\Media\Model
{

    /**
     * @return Query
     */
    public static function find()
    {
        return new Query(get_called_class());
    }
}
