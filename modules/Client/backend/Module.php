<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\backend;

use cookyii\modules\Client;
use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package cookyii\modules\Client\backend
 */
class Module extends \yii\base\Module implements \cookyii\interfaces\BackendModuleInterface
{

    /**
     * @inheritdoc
     */
    public function menu($Controller)
    {
        return [
            [
                'label' => \Yii::t('cookyii.client', 'Clients'),
                'url' => ['/client/list/index'],
                'icon' => FA::icon('users'),
                'visible' => User()->can(Client\backend\Permissions::ACCESS),
                'selected' => $Controller->module->id === 'client',
                'sort' => 2000,
            ],
        ];
    }
}