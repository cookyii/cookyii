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
class Module extends \yii\base\Module implements \yii\base\BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()
            ->addRules(include(__DIR__ . '/urls.php'));

        $app->getI18n()
            ->translations['page'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages',
        ];
    }
}