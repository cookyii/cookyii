<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\frontend;

/**
 * Class Module
 * @package cookyii\modules\Postman\frontend
 */
class Module extends \cookyii\modules\Postman\AbstractModule implements \yii\base\BootstrapInterface
{

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