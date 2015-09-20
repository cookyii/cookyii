<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend;

use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package cookyii\modules\Postman\backend
 */
class Module extends \cookyii\modules\Postman\AbstractModule implements \backend\interfaces\BackendModuleInterface, \yii\base\BootstrapInterface
{

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
                'visible' => User()->can(\cookyii\modules\Postman\backend\Permissions::ACCESS),
                'selected' => $Controller->module->id === 'postman',
                'sort' => 9000,
                'items' => [
                    [
                        'label' => \Yii::t('account', 'Messages'),
                        'url' => ['/postman/message/list'],
                        'icon' => FA::icon('send'),
                        'selected' => $Controller->module->id === 'postman' && $Controller->id === 'message',
                    ],
                    [
                        'label' => \Yii::t('account', 'Templates'),
                        'url' => ['/postman/template/list'],
                        'icon' => FA::icon('table'),
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
        $app->getI18n()
            ->translations['postman'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => \Yii::$app->sourceLanguage,
            'basePath' => '@app/messages',
        ];
    }
}