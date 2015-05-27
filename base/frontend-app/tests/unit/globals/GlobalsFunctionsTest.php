<?php
/**
 * GlobalsFunctionsTest.php
 * @author Revin Roman http://phptime.ru
 */

namespace frontend\tests\unit\globals;

use frontend\tests\unit\TestCase;
use services;
use yii;

/**
 * Class GlobalsFunctionsTest
 * @package frontend\tests\unit\globals
 */
class GlobalsFunctionsTest extends TestCase
{

    public function testMain()
    {
        ob_start();
        dump(['test' => rand()]); // это тест!
        expect('Функция дампа не отдает результат', ob_get_clean())->notEmpty();

        $this->assertInstanceOf(yii\log\Dispatcher::class, YiiLog());
        $this->assertInstanceOf(yii\db\Connection::class, DB());
        $this->assertInstanceOf(yii\base\ErrorHandler::class, ErrorHandler());
        $this->assertInstanceOf(yii\caching\Cache::class, Cache());
        $this->assertInstanceOf(yii\i18n\Formatter::class, Formatter());
        $this->assertInstanceOf(yii\base\View::class, View());
        $this->assertInstanceOf(yii\i18n\I18N::class, I18N());
        $this->assertInstanceOf(yii\rbac\ManagerInterface::class, AuthManager());
        $this->assertInstanceOf(yii\web\AssetManager::class, AssetManager());
        $this->assertInstanceOf(yii\web\User::class, User());
        $this->assertInstanceOf(yii\base\Request::class, Request());
        $this->assertInstanceOf(yii\base\Response::class, Response());
        $this->assertInstanceOf(yii\web\Session::class, Session());
        $this->assertInstanceOf(yii\web\UrlManager::class, UrlManager());
        $this->assertInstanceOf(yii\mail\MailerInterface::class, Mailer());
    }
}