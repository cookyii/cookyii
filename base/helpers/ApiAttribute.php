<?php
/**
 * ApiAttribute.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\helpers;

/**
 * Class ApiAttribute
 * @package cookyii\helpers
 */
class ApiAttribute
{

    public static $datetimeFormats = [
        'raw' => 'raw',
        'format' => 'd MMM HH:mm',
        'normal' => 'dd.MM.yyyy HH:mm',
    ];

    public static $dateFormats = [
        'raw' => 'raw',
        'format' => 'd MMM',
        'normal' => 'dd.MM.yyyy',
    ];

    public static $timeFormats = [
        'raw' => 'raw',
        'normal' => 'HH:mm',
    ];

    /**
     * @param array $fields
     * @param string $attribute
     * @param array|null $formats
     */
    public static function datetimeFormat(array &$fields, $attribute, $formats = [])
    {
        $formats = empty($formats) && $formats !== null
            ? static::$datetimeFormats
            : $formats;

        if (empty($formats)) {
            $fields[$attribute] = function (\yii\db\BaseActiveRecord $Model) use ($attribute) {
                return $Model->hasAttribute($attribute)
                    ? $Model->getAttribute($attribute)
                    : null;
            };
        } else {
            $fields[$attribute] = function (\yii\db\BaseActiveRecord $Model) use ($attribute, $formats) {
                $result = [];

                $value = $Model->hasAttribute($attribute)
                    ? $Model->getAttribute($attribute)
                    : null;

                foreach ($formats as $key => $format) {
                    $result[$key] = $format === 'raw'
                        ? (empty($value) ? null : $value)
                        : (empty($value) ? \Yii::t('yii', '(not set)') : Formatter()->asDatetime($value, $format));
                }

                return $result;
            };
        }
    }

    /**
     * @param array $fields
     * @param string $attribute
     */
    public static function dateFormat(array &$fields, $attribute)
    {
        static::datetimeFormat($fields, $attribute, static::$dateFormats);
    }

    /**
     * @param array $fields
     * @param string $attribute
     */
    public static function timeFormat(array &$fields, $attribute)
    {
        static::datetimeFormat($fields, $attribute, static::$timeFormats);
    }
}