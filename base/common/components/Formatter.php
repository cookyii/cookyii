<?php
/**
 * Formatter.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\components;

/**
 * Class Formatter
 * @package common\components
 */
class Formatter extends \yii\i18n\Formatter
{

    /**
     * @param integer|string|\DateTime $value the value to be formatted. The following
     * types of value are supported:
     *
     * - an integer representing a UNIX timestamp
     * - a string that can be [parsed to create a DateTime object](http://php.net/manual/en/datetime.formats.php).
     *   The timestamp is assumed to be in [[defaultTimeZone]] unless a time zone is explicitly given.
     * - a PHP [DateTime](http://php.net/manual/en/class.datetime.php) object
     * @param string $format the format used to convert the value into a date string.
     * If null, [[dateFormat]] will be used.
     *
     * This can be "short", "medium", "long", or "full", which represents a preset format of different lengths.
     * It can also be a custom format as specified in the [ICU manual](http://userguide.icu-project.org/formatparse/datetime).
     *
     * Alternatively this can be a string prefixed with `php:` representing a format that can be recognized by the
     * PHP [date()](http://php.net/manual/de/function.date.php)-function.
     * @param integer|string|\DateTime $referenceTime if specified the value is used as a reference time instead of `now`
     * when `$value` is not a `DateInterval` object.
     * @return string the formatted result.
     * @return string the formatted result.
     * @throws \yii\base\InvalidParamException if the input value can not be evaluated as a date value.
     * @throws \yii\base\InvalidConfigException if the date format is invalid.
     * @see datetimeFormat
     */
    public function asRelativeTime($value, $format = null, $referenceTime = null)
    {
        $check = time() - (int)$value;

        if (is_integer($value) && ($check >= 86400 || $check <= -86400 * 7)) {
            return $this->asDatetime($value, $format);
        }

        return parent::asRelativeTime($value, $referenceTime);
    }
}