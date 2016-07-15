<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace resources\Account;

/**
 * Class Model
 * @package resources\Account
 */
class Model extends \cookyii\modules\Account\resources\Account\Model
{

    /**
     * @return Query
     */
    public static function find()
    {
        return new Query(get_called_class());
    }
}
