<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend;

use cookyii\modules\Account;
use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package cookyii\modules\Account\backend
 */
class Module extends \yii\base\Module implements \backend\interfaces\BackendModuleInterface
{

    public $defaultRoute = 'sign/in';

    /**
     * @inheritdoc
     */
    public function menu($Controller)
    {
        return [
            [
                'label' => \Yii::t('cookyii.account', 'Accounts'),
                'url' => ['/account/list/index'],
                'icon' => FA::icon('user'),
                'visible' => User()->can(Account\backend\Permissions::ACCESS),
                'selected' => $Controller->module->id === 'account',
                'sort' => 10000,
            ],
        ];
    }
}