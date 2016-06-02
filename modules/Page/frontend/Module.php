<?php
/**
 * Module.php
 * @author Alexander Volkov
 */

namespace cookyii\modules\Page\frontend;

/**
 * Class Module
 * @package cookyii\modules\Page\frontend
 */
class Module extends \yii\base\Module implements \yii\base\BootstrapInterface, \cookyii\interfaces\FrontendModuleInterface
{

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