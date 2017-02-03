<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend;

use cookyii\Facade as F;
use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package cookyii\modules\Postman\backend
 */
class Module extends \cookyii\modules\Postman\Module implements \cookyii\interfaces\BackendModuleInterface
{

    /**
     * @inheritdoc
     */
    public function menu($Controller)
    {
        return [
            [
                'label' => \Yii::t('cookyii.postman', 'Postman'),
                'url' => ['/postman'],
                'icon' => FA::icon('envelope'),
                'visible' => F::User()->can(\cookyii\modules\Postman\backend\Permissions::ACCESS),
                'selected' => $Controller->module->id === 'postman',
                'sort' => 9000,
                'items' => [
                    [
                        'label' => \Yii::t('cookyii.postman', 'Messages'),
                        'url' => ['/postman/message/list'],
                        'icon' => FA::icon('send'),
                        'selected' => $Controller->module->id === 'postman' && $Controller->id === 'message',
                    ],
                    [
                        'label' => \Yii::t('cookyii.postman', 'Templates'),
                        'url' => ['/postman/template/list'],
                        'icon' => FA::icon('table'),
                        'selected' => $Controller->module->id === 'postman' && $Controller->id === 'template',
                    ],
                ],
            ],
        ];
    }
}