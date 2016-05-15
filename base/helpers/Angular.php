<?php
/**
 * Angular.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\helpers;

use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Class Angular
 * @package cookyii\helpers
 */
class Angular extends \yii\helpers\BaseHtml
{

    /**
     * @param array $values
     * @return string
     */
    public static function arrayOfExpressions(array $values)
    {
        $result = [];

        if (!empty($values)) {
            foreach ($values as $class => $expression) {
                $result[$class] = new JsExpression($expression);
            }
        }

        return Json::encode($result);
    }

    /**
     * @param array $values
     * @return string
     */
    public static function ngClass(array $values)
    {
        return static::arrayOfExpressions($values);
    }

    /**
     * @param array $values
     * @return string
     */
    public static function ngStyle(array $values)
    {
        return static::arrayOfExpressions($values);
    }

    /**
     * @param array $values
     * @param string $operator
     * @return string
     */
    public static function ngIf(array $values, $operator = '&&')
    {
        $result = [];

        if (!empty($values)) {
            foreach ($values as $attribute => $compare) {
                if (is_array($compare)) {
                    $result[] = sprintf(Json::encode($compare) . '.indexOf(%s) > -1', $attribute);
                } else {
                    $result[] = sprintf('%s === %s', $attribute, $compare);
                }
            }
        }

        return trim(implode(sprintf(' %s ', $operator), $result));
    }
}