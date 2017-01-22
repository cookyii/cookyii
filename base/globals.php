<?php
/**
 * globals.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

@umask(0002);

use cookyii\Decorator as D;

/**
 * Dumps a variable in terms of a string.
 * This method achieves the similar functionality as var_dump and print_r
 * but is more robust when handling complex objects such as Yii controllers.
 * @param mixed $var variable to be dumped
 * @param integer $depth maximum depth that the dumper should go into the variable. Defaults to 10.
 * @param boolean $highlight whether the result should be syntax-highlighted
 * @param bool $return whether the result should be returned (true) or print (false)
 * @return string|null
 */
function dump($var, $depth = 10, $highlight = true, $return = false)
{
    $dump = \yii\helpers\VarDumper::dumpAsString($var, $depth, $highlight);

    if ($return === true) {
        return $dump;
    } else {
        echo $dump;
    }

    return null;
}

/**
 * @deprecated
 * @return \resources\Account\Model
 */
function Account()
{
    return D::User()->identity;
}

/**
 * @deprecated
 * @return \yii\web\Request|\yii\console\Request
 */
function Request()
{
    return \Yii::$app->getRequest();
}

/**
 * @deprecated
 * @return \yii\web\Response|\yii\console\Response
 */
function Response()
{
    return \Yii::$app->getResponse();
}

/**
 * @deprecated
 * @return \yii\web\Session
 */
function Session()
{
    return \Yii::$app->get('session'); // `get()` for console application
}

/**
 * @deprecated
 * @return \yii\base\Security
 */
function Security()
{
    return \Yii::$app->getSecurity();
}

/**
 * @deprecated
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
 * @deprecated
 * @return \yii\log\Dispatcher
 */
function YiiLog()
{
    return \Yii::$app->getLog();
}

/**
 * @deprecated
 * @return \yii\web\ErrorHandler|\yii\console\ErrorHandler
 */
function ErrorHandler()
{
    return \Yii::$app->getErrorHandler();
}

/**
 * @deprecated
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
 * @deprecated
 * @return \yii\db\Connection
 */
function Db()
{
    return \Yii::$app->getDb();
}

/**
 * @deprecated
 * @return \yii\i18n\I18N
 */
function I18N()
{
    return \Yii::$app->getI18n();
}

/**
 * @deprecated
 * @return \yii\i18n\Formatter
 */
function Formatter()
{
    return \Yii::$app->getFormatter();
}

/**
 * @deprecated
 * @return \yii\base\View|\yii\web\View
 */
function View()
{
    return \Yii::$app->getView();
}

/**
 * @deprecated
 * @return \yii\mail\MailerInterface
 */
function Mailer()
{
    return \Yii::$app->getMailer();
}

/**
 * @deprecated
 * @return \yii\rbac\DbManager
 */
function AuthManager()
{
    return \Yii::$app->getAuthManager();
}

/**
 * @deprecated
 * @return \yii\web\User
 */
function User()
{
    return \Yii::$app->getUser();
}

/**
 * @deprecated
 * @return \yii\web\AssetManager
 */
function AssetManager()
{
    return \Yii::$app->getAssetManager();
}

/**
 * @deprecated
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
    return str_pretty(strip_tags($str));
}

/**
 * @param string $str
 * @return string
 */
function str_pretty($str)
{
    $str = preg_replace('/[^\P{C}\s]+/u', '', $str);
    $str = preg_replace('/(\r?\n){2,}/', "\r\n\r\n", $str);
    $str = preg_replace('/\t+/', ' ', $str);
    $str = preg_replace('/( ){2,}/', ' ', $str);

    return trim($str);
}

/**
 * @param $email
 * @param $size
 * @return string
 */
function gravatar($email, $size)
{
    $hash = md5(strtolower(trim($email)));

    $size = $size < 0 ? 10 : $size;
    $size = $size > 1000 ? 1000 : $size;

    $query = [
        's' => $size,
        'd' => 'mm',
        'r' => 'g',
    ];

    return sprintf('http://www.gravatar.com/avatar/%s?%s', $hash, http_build_query($query));
}