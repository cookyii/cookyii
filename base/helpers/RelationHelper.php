<?php
/**
 * RelationHelper.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\helpers;

use yii\db\ActiveQuery;

/**
 * Class RelationHelper
 * @package cookyii\helpers
 */
class RelationHelper
{

    /**
     * @param array|string $with
     * @param callable|null $handler
     * @return \Closure
     */
    public static function with($with, $handler = null)
    {
        return function (ActiveQuery $Query) use ($with, $handler) {
            $Query->with($with);

            if (is_callable($handler)) {
                $handler($Query);
            }
        };
    }
}
