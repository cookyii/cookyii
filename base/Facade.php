<?php
/**
 * Facade.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii;

/**
 * Class Facade
 * @package cookyii
 */
class Facade
{

    /**
     * @return \resources\Account\Model
     */
    public static function Account()
    {
        return static::User()->identity;
    }

    /**
     * @return \yii\web\Request|\yii\console\Request
     */
    public static function Request()
    {
        return \Yii::$app->getRequest();
    }

    /**
     * @return \yii\web\Response|\yii\console\Response
     */
    public static function Response()
    {
        return \Yii::$app->getResponse();
    }

    /**
     * @return \yii\web\Session
     */
    public static function Session()
    {
        return \Yii::$app->get('session'); // `get()` for console application
    }

    /**
     * @return \yii\base\Security
     */
    public static function Security()
    {
        return \Yii::$app->getSecurity();
    }

    /**
     * @param string|null $type
     * @return \yii\web\UrlManager
     * @throws \yii\base\InvalidConfigException
     */
    public static function UrlManager($type = null)
    {
        $type = empty($type) ? '' : ('.' . $type);

        return \Yii::$app->get('urlManager' . $type);
    }

    /**
     * @return \yii\queue\Queue
     */
    public static function Queue()
    {
        return \Yii::$app->get('queue');
    }

    /**
     * @return \yii\log\Dispatcher
     */
    public static function YiiLog()
    {
        return \Yii::$app->getLog();
    }

    /**
     * @return \yii\web\ErrorHandler|\yii\console\ErrorHandler
     */
    public static function ErrorHandler()
    {
        return \Yii::$app->getErrorHandler();
    }

    /**
     * @param string|null $type
     * @return \yii\caching\Cache
     * @throws \yii\base\InvalidConfigException
     */
    public static function Cache($type = null)
    {
        $type = empty($type) ? '' : ('.' . $type);

        return \Yii::$app->get('cache' . $type);
    }

    /**
     * @return \yii\db\Connection
     */
    public static function Db()
    {
        return \Yii::$app->getDb();
    }

    /**
     * @return \yii\i18n\I18N
     */
    public static function I18N()
    {
        return \Yii::$app->getI18n();
    }

    /**
     * @return \cookyii\i18n\Formatter
     */
    public static function Formatter()
    {
        return \Yii::$app->getFormatter();
    }

    /**
     * @return \yii\base\View|\yii\web\View
     */
    public static function View()
    {
        return \Yii::$app->getView();
    }

    /**
     * @return \yii\mail\MailerInterface
     */
    public static function Mailer()
    {
        return \Yii::$app->getMailer();
    }

    /**
     * @return \yii\rbac\DbManager
     */
    public static function AuthManager()
    {
        return \Yii::$app->getAuthManager();
    }

    /**
     * @return \yii\web\User
     */
    public static function User()
    {
        return \Yii::$app->getUser();
    }

    /**
     * @return \yii\web\AssetManager
     */
    public static function AssetManager()
    {
        return \Yii::$app->getAssetManager();
    }

    /**
     * @return \yii\authclient\Collection
     */
    public static function AuthClientCollection()
    {
        return \Yii::$app->get('authClientCollection');
    }
}
