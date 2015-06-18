<?php
/**
 * Config.php
 * @author Revin Roman
 */

namespace components;

/**
 * Class Config
 * @package components
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
}