<?php
/**
 * Module.php
 * @author Revin Roman
 */

namespace cookyii\modules\Client\backend;

use cookyii\modules\Client;
use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package cookyii\modules\Client\backend
 */
class Module extends \yii\base\Module implements \backend\interfaces\BackendModuleInterface, \yii\base\BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function menu($Controller)
    {
        return [
            [
                'label' => \Yii::t('account', 'Clients'),
                'url' => ['/client/list/index'],
                'icon' => FA::icon('users'),
                'visible' => User()->can(Client\backend\Permissions::ACCESS),
                'selected' => $Controller->module->id === 'client',
                'sort' => 2000,
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
            ->translations['client'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages',
        ];
    }
}