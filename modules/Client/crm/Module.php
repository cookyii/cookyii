<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\crm;

use cookyii\modules\Client;
use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package cookyii\modules\Client\crm
 */
class Module extends \yii\base\Module implements \crm\interfaces\CrmModuleInterface
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
                'visible' => User()->can(Client\crm\Permissions::ACCESS),
                'selected' => $Controller->module->id === 'client',
                'sort' => 2000,
            ],
        ];
    }
}