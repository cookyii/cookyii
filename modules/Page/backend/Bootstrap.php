<?php
/**
 * Bootstrap.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\modules\Page\backend;

/**
 * Class Bootstrap
 * @package cookyii\modules\Page\backend
 */
class Bootstrap implements \yii\base\BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($APP)
    {
        $APP->getUrlManager()
            ->addRules(include(__DIR__ . '/urls.php'));

        $APP->getI18n()
            ->translations['page'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages',
        ];
    }
}