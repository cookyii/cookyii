<?php
/**
 * Config.php
 * @author Revin Roman
 */

namespace cookyii;

/**
 * Class Config
 * @package cookyii
 */
class Config
{

    static $config = [];

    /**
     * Disabled constructor
     */
    private function __construct()
    {

    }

    /**
     * @param string $app
     * @param string $type
     * @throws \yii\base\Exception
     */
    public static function init($app, $type)
    {
        if (empty(static::$config)) {
            self::reload($app, $type);
        }
    }

    /**
     * @param string $app
     * @param string $type
     * @throws \yii\base\Exception
     */
    public static function reload($app, $type)
    {
        $filename = sprintf('%s.php', $type);

        $config_alias = sprintf('@%s/config/%s', $app, $filename);
        $local_config_alias = sprintf('@%s/config/%s/%s', $app, getenv('YII_ENV'), $filename);

        $config = \Yii::getAlias($config_alias);
        $local_config = \Yii::getAlias($local_config_alias);

        if (file_exists($local_config)) {
            $_config = $local_config;
        } elseif (file_exists($config)) {
            $_config = $config;
        } else {
            throw new \yii\base\Exception(sprintf('Application config not exists (%s).', $config_alias));
        }

        static::$config = require($_config);
    }

    /**
     * @param $baseDir
     * @throw \RuntimeException
     */
    public static function requireGlobals($baseDir)
    {
        if (file_exists($baseDir . '/globals.php')) {
            require($baseDir . '/globals.php');
        } elseif (file_exists($baseDir . '/components/globals.php')) {
            require($baseDir . '/components/globals.php');
        } elseif (file_exists($baseDir . '/vendor/cookyii/base/globals.php')) {
            require($baseDir . '/vendor/cookyii/base/globals.php');
        } else {
            throw new \RuntimeException('Unable to locate a file `globals.php`');
        }
    }

    /**
     * Setting timezone from cookies or session
     */
    public static function loadTimeZone()
    {
        $gmt = 0;

        if (isset($_COOKIE['timezone'])) {
            $gmt = (int)$_COOKIE['timezone'];
        }

        if (Session()->has('timezone')) {
            $gmt = (int)Session()->get('timezone', 0);
        }

        $gmt = $gmt < -14 || $gmt > 12 // GMT-14 && GMT+12
            ? 0
            : $gmt;

        if ($gmt <= 0) {
            $char = '-';
        } else {
            $char = '+';
        }

        $timezone = sprintf('Etc/GMT%s%d', $char, abs($gmt));

        \Yii::$app->formatter->timeZone = $timezone;
        \Yii::$app->timeZone = $timezone;
    }
}