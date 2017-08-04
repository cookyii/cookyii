<?php
/**
 * CronJob.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\queue;

use cookyii\Facade;
use yii\base\InvalidParamException;

/**
 * Class CronJob
 * @package cookyii\queue
 */
abstract class CronJob extends BaseJob
{

    /**
     * @var array
     */
    protected $timing = [];

    /**
     * @return bool
     * @throws \Exception
     */
    abstract public function schedule();

    /**
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidParamException
     */
    public function isNeedExecute()
    {
        $timing = $this->getTiming();

        $time = time();

        $current = array_combine(
            ['min', 'hour', 'day', 'month', 'dayOfWeek'],
            explode(' ', Facade::Formatter()->asDatetime($time, 'm H d M e'))
        );

        $result = true;

        foreach ($current as $key => $item) {
            if (!in_array((int)$item, $timing[$key], true)) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * @return array
     * @throws \yii\base\InvalidParamException
     */
    protected function getTiming()
    {
        $timing = array_merge([
            'min'       => '*',
            'hour'      => '*',
            'day'       => '*',
            'month'     => '*',
            'dayOfWeek' => '*',
        ], $this->timing);

        $threshold = [
            'min'       => ['min' => 0, 'max' => 59],
            'hour'      => ['min' => 0, 'max' => 23],
            'day'       => ['min' => 1, 'max' => 31],
            'month'     => ['min' => 1, 'max' => 12],
            'dayOfWeek' => ['min' => 1, 'max' => 7],
        ];

        return $this->parseTiming($timing, $threshold);
    }

    /**
     * @param array $timing
     * @param array $threshold
     * @return array
     * @throws \yii\base\InvalidParamException
     */
    private function parseTiming(array $timing, array $threshold)
    {
        $result = [];

        foreach ($timing AS $type => $value) {
            if (is_numeric($value) && ($value >= $threshold[$type]['min'] && $value <= $threshold[$type]['max'])) {
                $result[$type][] = (int)$value;
            } elseif ($value === '*') {
                $result[$type] = range($threshold[$type]['min'], $threshold[$type]['max']);
            } elseif (preg_match('/\d+-\d+/', $value)) {
                list($min, $max) = explode('-', $value);

                if ($min > $max) {
                    $_min = $min;
                    $_max = $max;

                    $min = $_max;
                    $max = $_min;

                    unset($_min, $_max);
                }

                $values = range($threshold[$type]['min'], $threshold[$type]['max']);

                foreach ($values as $val) {
                    if (is_numeric($val) && ($val >= $min && $val <= $max)) {
                        $result[$type][] = (int)$val;
                    }
                }

            } elseif (preg_match('/\*\/\d+/', $value)) {
                $repeatDivider = explode('/', $value)[1];

                $values = range($threshold[$type]['min'], $threshold[$type]['max']);

                foreach ($values as $val) {
                    if ($val === 0) {
                        $result[$type][] = (int)$val;
                    } elseif ($val % $repeatDivider === 0) {
                        $result[$type][] = (int)$val;
                    }
                }
            } elseif (preg_match('/[,\d+]/', $value)) {
                $values = explode(',', $value);

                foreach ($values as $val) {
                    if (is_numeric($val) && ($val >= $threshold[$type]['min'] && $val <= $threshold[$type]['max'])) {
                        $result[$type][] = (int)$val;
                    }
                }
            } else {
                throw new InvalidParamException("Invalid timing parameter: $type => $value");
            }
        }

        return $result;
    }
}
