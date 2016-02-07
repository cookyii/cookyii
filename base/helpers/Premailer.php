<?php
/**
 * Premailer.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\helpers;

/**
 * Class Premailer
 * @package cookyii\helpers
 */
class Premailer
{

    /**
     * @param array $arguments
     * @return string
     */
    public static function renderArgumentString(array $arguments)
    {
        $result = '';

        foreach ($arguments as $name => $value) {
            if (is_bool($value)) {
                if ($value === true) {
                    $result .= ' --' . ($name);
                }
            } else {
                $result .= ' --' . ($name) . ' ' . ($value);
            }
        }

        return $result;
    }

    /**
     * @param $markup
     * @return string
     * @throws \yii\base\ErrorException
     */
    public static function getConvertedHtml($markup)
    {
        $arguments = ['mode' => 'html'];

        $output = [];
        $returnVar = 0;

        $file = tempnam(sys_get_temp_dir(), 'email-html-');
        file_put_contents($file, $markup);

        $command = 'cat ' . $file . ' | premailer ' . static::renderArgumentString($arguments);
        exec($command, $output, $returnVar);

        unlink($file);

        if ($returnVar > 0) {
            throw new \yii\base\ErrorException(sprintf('Premailer return bad result code - %d', $returnVar));
        }

        return implode('', $output);
    }

    /**
     * @param $markup
     * @return string
     * @throws \yii\base\ErrorException
     */
    public static function getConvertedText($markup)
    {
        $arguments = ['mode' => 'txt'];

        $output = [];
        $returnVar = 0;

        $file = tempnam(sys_get_temp_dir(), 'email-text-');
        file_put_contents($file, $markup);

        $command = 'cat ' . $file . ' | premailer ' . static::renderArgumentString($arguments);
        exec($command, $output, $returnVar);

        unlink($file);

        if ($returnVar > 0) {
            throw new \yii\base\ErrorException(sprintf('Premailer return bad result code - %d', $returnVar));
        }

        return implode('', $output);
    }
}
