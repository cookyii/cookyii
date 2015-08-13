<?php
/**
 * Module.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\crm;

use cookyii\modules\Account;
use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package cookyii\modules\Account\crm
 */
class Module extends \yii\base\Module implements \crm\interfaces\CrmModuleInterface, \yii\base\BootstrapInterface
{

    public $defaultRoute = 'sign/in';

    /**
     * @inheritdoc
     */
    public function menu($Controller)
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getI18n()
            ->translations['account'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages',
        ];
    }
}