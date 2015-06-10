<?php
/**
 * Config.php
 * @author Revin Roman
 */

namespace common\components;

/**
 * Class Config
 * @package common\components
 */
class Config
{

    static $config = [];

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

        $common_config_alias = sprintf('@common/config/%s', $filename);
        $config_alias = sprintf('@%s/config/%s', $app, $filename);
        $local_config_alias = sprintf('@%s/config/%s/%s', $app, getenv('YII_ENV'), $filename);

        $common_config = \Yii::getAlias($common_config_alias);
        $config = \Yii::getAlias($config_alias);
        $local_config = \Yii::getAlias($local_config_alias);

        if (!file_exists($common_config)) {
            throw new \yii\base\Exception(sprintf('Common config not exists (%s).', $common_config_alias));
        }

        if (file_exists($local_config)) {
            $_config = $local_config;
        } elseif (file_exists($config)) {
            $_config = $config;
        } else {
            throw new \yii\base\Exception(sprintf('Application config not exists (%s).', $config_alias));
        }

        static::$config = \yii\helpers\ArrayHelper::merge(
            require($common_config),
            require($_config)
        );
    }
}