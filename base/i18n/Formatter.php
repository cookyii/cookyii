<?php
/**
 * Formatter.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\i18n;

use yii\helpers\ArrayHelper;

/**
 * Class Formatter
 * @package cookyii\i18n
 */
class Formatter extends \yii\i18n\Formatter
{

    /** @var array */
    public $shortNumberSuffix = [
        0 => '',
        1 => 'k',
        2 => 'm',
        3 => 'b',
    ];

    /**
     * @param integer $number The value to formatting
     * @param integer $precision The optional number of decimal digits to round to.
     * @param int $mode One of PHP_ROUND_HALF_UP, PHP_ROUND_HALF_DOWN, PHP_ROUND_HALF_EVEN, PHP_ROUND_HALF_ODD.
     * @param int $multiplier private prop offset for recursion
     * @return string
     */
    public function asShortNumber($number, $precision = 1, $mode = PHP_ROUND_HALF_UP, $multiplier = 0)
    {
        $d = $number / 1000;

        if ($d < 1) {
            return round($number, $precision, $mode) . $this->shortNumberSuffix[$multiplier];
        } elseif ($d >= 1000 && isset($this->shortNumberSuffix[$multiplier + 2])) {
            return $this->asShortNumber($d, $precision, $mode, $multiplier + 1);
        } else {
            return round($d, $precision, $mode) . $this->shortNumberSuffix[$multiplier + 1];
        }
    }

    /**
     * @inheritdoc
     */
    public function asDecimal($value, $decimals = 2, $options = [], $textOptions = [])
    {
        $stripNullDecimals = ArrayHelper::remove($options, 'stripNullDecimals', true);

        $result = parent::asDecimal($value, $decimals, $options, $textOptions);

        if ($stripNullDecimals) {
            if (extension_loaded('intl')) {
                $f = $this->createNumberFormatter(\NumberFormatter::DECIMAL, $decimals, $options, $textOptions);
                $sep = $f->getSymbol(\NumberFormatter::DECIMAL_SEPARATOR_SYMBOL);
            } else {
                $sep = $this->decimalSeparator;
            }

            $result = str_replace($sep . str_repeat('0', $decimals), '', $result);
        }

        return $result;
    }

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