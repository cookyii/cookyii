<?php
/**
 * Bootstrap.php
 * @author Revin Roman http://phptime.ru
 */

namespace cookyii\modules\Media;

/**
 * Class Bootstrap
 * @package cookyii\modules\Media
 */
class Bootstrap implements \yii\base\BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($APP)
    {
        $APP->getI18n()
            ->translations['media'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages',
        ];
    }
}