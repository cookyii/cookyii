<?php
/**
 * Module.php
 * @author Alexander Volkov
 */

namespace cookyii\modules\Translation\backend;

use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package namespace cookyii\modules\Translation\backend
 */
class Module extends \yii\base\Module implements \backend\interfaces\BackendModuleInterface, \yii\base\BootstrapInterface
{

    /** @var string */
    public $messagesConfig = '@base/messages/config.php';

    /**
     * @inheritdoc
     */
    public function menu($Controller)
    {
        return [
            [
                'label' => \Yii::t('translation', 'Translation'),
                'url' => ['/translation/list/index'],
                'icon' => FA::icon('globe'),
                'visible' => User()->can(Permissions::ACCESS),
                'selected' => $Controller->module->id === 'translation',
                'sort' => 9000,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getI18n()
            ->translations['translation'] = [
            'class' => \yii\i18n\PhpMessageSource::className(),
            'sourceLanguage' => \Yii::$app->sourceLanguage,
            'basePath' => __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'messages',
        ];
    }
}