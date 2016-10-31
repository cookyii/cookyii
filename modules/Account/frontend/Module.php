<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\frontend;

use cookyii\modules\Account;

/**
 * Class Module
 * @package cookyii\modules\Account\frontend
 */
class Module extends \yii\base\Module implements \yii\base\BootstrapInterface, \cookyii\interfaces\FrontendModuleInterface
{

    public $defaultRoute = 'sign/in';

    public $roles = [
        'admin' => 'admin',
        'user' => 'user',
    ];

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getI18n()
            ->translations['account'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => \Yii::$app->sourceLanguage,
            'basePath' => '@app/messages',
        ];
    }
}