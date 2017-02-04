<?php
/**
 * DaemonOutputTrait.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\console;

use app\Facade as F;
use yii\helpers\Console;

/**
 * Trait DaemonOutputTrait
 * @package cookyii\console
 */
trait DaemonOutputTrait
{

    /**
     * @return string
     */
    public function time()
    {
        return F::Formatter()->asTime(time(), 'HH:mm:ss');
    }

    /**
     * @param string $message
     * @param bool $nl
     */
    public function out($message, $nl = true)
    {
        $message = empty($message)
            ? ''
            : sprintf('  %s > %s', $this->time(), $message);

        $nl = $nl ? "\n" : '';

        echo $message . $nl;
    }

    /**
     * @param string $message
     * @param bool $nl
     */
    public function err($message, $nl = true)
    {
        $message = empty($message)
            ? ''
            : sprintf('  %s > Error: %s', $this->time(), $message);

        $nl = $nl ? "\n" : '';

        echo $message . $nl;
    }

    /**
     * @param string $message
     * @param bool $nl
     */
    public function sep($message, $nl = true)
    {
        $nl = $nl ? "\n" : '';

        echo '  ' . $message . $nl;
    }

    /**
     * Prints a string to STDOUT
     *
     * You may optionally format the string with ANSI codes by
     * passing additional parameters using the constants defined in [[\yii\helpers\Console]].
     *
     * Example:
     *
     * ```
     * $this->stdout('This will be red and underlined.', Console::FG_RED, Console::UNDERLINE);
     * ```
     *
     * @param string $string the string to print
     * @return integer|boolean Number of bytes printed or false on error
     */
    public function stdout($string)
    {
        $STDOUT = isset($this->daemon->STDOUT) && !empty($this->daemon->STDOUT) && is_resource($this->daemon->STDOUT)
            ? $this->daemon->STDOUT
            : \STDOUT;

        if ($this->isColorEnabled($STDOUT)) {
            $args = func_get_args();
            array_shift($args);
            $string = Console::ansiFormat($string, $args);
        }

        return fwrite($STDOUT, $string);
    }

    /**
     * Prints a string to STDERR
     *
     * You may optionally format the string with ANSI codes by
     * passing additional parameters using the constants defined in [[\yii\helpers\Console]].
     *
     * Example:
     *
     * ```
     * $this->stderr('This will be red and underlined.', Console::FG_RED, Console::UNDERLINE);
     * ```
     *
     * @param string $string the string to print
     * @return integer|boolean Number of bytes printed or false on error
     */
    public function stderr($string)
    {
        $STDERR = isset($this->daemon->STDERR) && !empty($this->daemon->STDERR) && is_resource($this->daemon->STDERR)
            ? $this->daemon->STDERR
            : \STDERR;

        if ($this->isColorEnabled($STDERR)) {
            $args = func_get_args();
            array_shift($args);
            $string = Console::ansiFormat($string, $args);
        }

        return fwrite($STDERR, $string);
    }
}
