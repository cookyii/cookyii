<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Page\backend;

use cookyii\modules\Page;
use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package cookyii\modules\Page\backend
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
                'label' => \Yii::t('page', 'Pages'),
                'url' => ['/page/list/index'],
                'icon' => FA::icon('file'),
                'visible' => User()->can(Page\backend\Permissions::ACCESS),
                'selected' => $Controller->module->id === 'page',
                'sort' => 8000,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getI18n()
            ->translations['page'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => \Yii::$app->sourceLanguage,
            'basePath' => '@app/messages',
        ];
    }
}