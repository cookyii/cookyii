<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend;

use cookyii\modules\Feed;
use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package cookyii\modules\Feed\backend
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
                'label' => \Yii::t('account', 'Feeds'),
                'url' => ['/feed/list/index'],
                'icon' => FA::icon('bars'),
                'visible' => User()->can(Feed\backend\Permissions::ACCESS),
                'selected' => $Controller->module->id === 'feed',
                'sort' => 1000,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getI18n()
            ->translations['feed'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => \Yii::$app->sourceLanguage,
            'basePath' => '@app/messages',
        ];
    }
}