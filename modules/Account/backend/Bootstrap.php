<?php
/**
 * Bootstrap.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\modules\Account\backend;

/**
 * Class Bootstrap
 * @package cookyii\modules\Account\backend
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
            ->translations['account'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages',
        ];
    }
}