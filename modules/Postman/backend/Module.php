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