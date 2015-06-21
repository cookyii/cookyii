<?php
/**
 * Module.php
 * @author Revin Roman
 */

namespace cookyii\modules\Postman\backend;

use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package cookyii\modules\Postman\backend
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
                'label' => \Yii::t('account', 'Postman'),
                'url' => ['/postman'],
                'icon' => FA::icon('envelope'),
                'visible' => User()->can(\cookyii\modules\Postman\backend\Permissions::POSTMAN_ACCESS),
                'selected' => $Controller->module->id === 'postman',
                'sort' => 9000,
                'items' => [
                    [
                        'label' => \Yii::t('account', 'Messages'),
                        'url' => ['/postman/message/list'],
                        'icon' => FA::icon('send'),
                        'visible' => User()->can(\cookyii\modules\Postman\backend\Permissions::POSTMAN_ACCESS),
                        'selected' => $Controller->module->id === 'postman' && $Controller->id === 'message',
                    ],
                    [
                        'label' => \Yii::t('account', 'Templates'),
                        'url' => ['/postman/template/list'],
                        'icon' => FA::icon('table'),
                        'visible' => User()->can(\cookyii\modules\Postman\backend\Permissions::POSTMAN_ACCESS),
                        'selected' => $Controller->module->id === 'postman' && $Controller->id === 'template',
                    ],
                ],
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
            ->translations['postman'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages',
        ];
    }
}