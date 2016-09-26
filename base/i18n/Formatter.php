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
}
