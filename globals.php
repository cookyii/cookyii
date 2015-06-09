<?php
/**
 * globals.php
 * @author Revin Roman http://phptime.ru
 */

@umask(0002);

/**
 * Dumps a variable in terms of a string.
 * This method achieves the similar functionality as var_dump and print_r
 * but is more robust when handling complex objects such as Yii controllers.
 * @param mixed $var variable to be dumped
 * @param integer $depth maximum depth that the dumper should go into the variable. Defaults to 10.
 * @param boolean $highlight whether the result should be syntax-highlighted
 * @return void output the string representation of the variable
 */
function dump($var, $depth = 10, $highlight = true)
{
    echo \yii\helpers\VarDumper::dumpAsString($var, $depth, $highlight);
}

/**
 * @return \yii\db\Connection
 */
function Db()
{
    return \Yii::$app->getDb();
}

/**
 * @return \yii\base\Security
 */
function Security()
{
    return \Yii::$app->getSecurity();
}

/**
 * @return \yii\log\Dispatcher
 */
function YiiLog()
{
    return \Yii::$app->getLog();
}

/**
 * @return \yii\web\ErrorHandler|\yii\console\ErrorHandler
 */
function ErrorHandler()
{
    return \Yii::$app->getErrorHandler();
}

/**
 * @param string|null $type
 * @return \yii\caching\Cache
 * @throws \yii\base\InvalidConfigException
 */
function Cache($type = null)
{
    $type = empty($type) ? '' : ('.' . $type);

    return \Yii::$app->get('cache' . $type);
}

/**
 * @return \yii\i18n\Formatter
 */
function Formatter()
{
    return \Yii::$app->getFormatter();
}

/**
 * @return \yii\web\Request|\yii\console\Request
 */
function Request()
{
    return \Yii::$app->getRequest();
}

/**
 * @return \yii\web\Response|\yii\console\Response
 */
function Response()
{
    return \Yii::$app->getResponse();
}

/**
 * @return \yii\base\View|\yii\web\View
 */
function View()
{
    return \Yii::$app->getView();
}

/**
 * @param string|null $type
 * @return \yii\web\UrlManager
 * @throws \yii\base\InvalidConfigException
 */
function UrlManager($type = null)
{
    $type = empty($type) ? '' : ('.' . $type);

    return \Yii::$app->get('urlManager' . $type);
}

/**
 * @return \yii\i18n\I18N
 */
function I18N()
{
    return \Yii::$app->getI18n();
}

/**
 * @return \yii\mail\MailerInterface
 */
function Mailer()
{
    return \Yii::$app->getMailer();
}

/**
 * @return \yii\rbac\ManagerInterface
 */
function AuthManager()
{
    return \Yii::$app->getAuthManager();
}

/**
 * @return \yii\web\Session
 */
function Session()
{
    return \Yii::$app->get('session');
}

/**
 * @return \yii\web\User
 */
function User()
{
    return \Yii::$app->getUser();
}

/**
 * @return \yii\web\AssetManager
 */
function AssetManager()
{
    return \Yii::$app->getAssetManager();
}

/**
 * @return \yii\authclient\Collection
 */
function AuthClientCollection()
{
    return \Yii::$app->get('authClientCollection');
}

/**
 * @param mixed $value
 * @return integer|null
 */
function nulled($value)
{
    return empty($value) ? null : $value;
}

/**
 * @param string $str
 * @return string
 */
function str_clean($str)
{
    return trim(preg_replace('/(\r?\n){2,}/', "\n\n", strip_tags($str)));
}