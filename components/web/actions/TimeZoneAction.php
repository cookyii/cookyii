<?php
/**
 * TimeZoneAction.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace components\web\actions;

/**
 * Class TimeZoneAction
 * @package components\web\actions
 */
class TimeZoneAction extends \yii\base\Action
{

    /**
     * @param integer $v
     * @return bool
     */
    public function run($v)
    {
        $gmt = (int)$v;

        $gmt = $gmt < -14 || $gmt > 12 // GMT-14 && GMT+12
            ? 0
            : $gmt;

        Session()->set('timezone', $gmt);

        return true;
    }
}