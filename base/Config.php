<?php
/**
 * Config.php
 * @author Revin Roman
 * @link https://rmrevin.com
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
        $local_config_alias = sprintf('@%s/config/%s/%s', $app, YII_ENV, $filename);
        $local_bootstrap_alias = sprintf('@%s/config/%s/%s', $app, YII_ENV, 'bootstrap.php');

        $config = \Yii::getAlias($config_alias);
        $local_config = \Yii::getAlias($local_config_alias);
        $local_bootstrap = \Yii::getAlias($local_bootstrap_alias);

        if (file_exists($local_config)) {
            $_config = $local_config;
        } elseif (file_exists($config)) {
            $_config = $config;
        } else {
            throw new \yii\base\Exception(sprintf('Application config not exists (%s).', $config_alias));
        }

        if (!empty($local_bootstrap) && file_exists($local_bootstrap)) {
            require_once $local_bootstrap;
        }

        static::$config = require_once $_config;
    }

    /**
     * @param $baseDir
     * @throw \RuntimeException
     */
    public static function requireGlobals($baseDir)
    {
        $files = [
            $baseDir . '/globals.php',
            $baseDir . '/base/globals.php',
            $baseDir . '/vendor/cookyii/base/globals.php',
        ];

        foreach ($files as $file) {
            if (file_exists($file)) {
                require_once $file;
                break;
            }
        }
    }

    /**
     * Setting timezone from cookies, account or session
     * @param mixed $force
     * @throws \yii\base\InvalidConfigException
     */
    public static function loadTimeZone($force = false)
    {
        $gmt = 0;

        $cookie_gmt = 0;
        $account_gmt = 0;
        $session_gmt = 0;

        if (isset($_COOKIE['timezone'])) {
            $gmt = $cookie_gmt = (int)$_COOKIE['timezone'];
        }

        if (!User()->isGuest) {
            /** @var \resources\Account\Model $Account */
            $Account = User()->identity;

            $gmt = $account_gmt = !empty($Account->timezone)
                ? $Account->timezone
                : $gmt;
        }

        $Session = \Yii::$app->get('session', false);

        if ($Session && $Session->has('timezone')) {
            $gmt = $session_gmt = (int)$Session->get('timezone', 0);
        }

        if (is_integer($force)) {
            $gmt = $force;
        } elseif (is_string($force) && in_array($force, ['cookie', 'cookies', 'account', 'session'])) {
            switch ($force) {
                case 'cookie':
                case 'cookies':
                    $gmt = $cookie_gmt;
                    break;
                case 'account':
                    $gmt = $account_gmt;
                    break;
                case 'session':
                    $gmt = $session_gmt;
                    break;
            }
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

        \Yii::$app->formatter->defaultTimeZone = $timezone;
        \Yii::$app->formatter->timeZone = $timezone;
        \Yii::$app->timeZone = $timezone;
    }
}