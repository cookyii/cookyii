<?php
/**
 * Module.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\backend;

use cookyii\modules\Account;
use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package cookyii\modules\Account\backend
 */
class Module extends \yii\base\Module implements \backend\interfaces\BackendModuleInterface, \yii\base\BootstrapInterface
{

    public $defaultRoute = 'sign/in';

    /**
     * @inheritdoc
     */
    public function menu($Controller)
    {
        return [
            [
                'label' => \Yii::t('account', 'Accounts'),
                'url' => ['/account/list/index'],
                'icon' => FA::icon('user'),
                'visible' => User()->can(Account\backend\Permissions::ACCESS),
                'selected' => $Controller->module->id === 'account',
                'sort' => 10000,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()
            ->addRules(include(__DIR__ . '/urls.php'));

        $app->getI18n()
            ->translations['account'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages',
        ];
    }
}