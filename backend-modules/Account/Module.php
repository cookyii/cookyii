<?php
/**
 * Module.php
 * @author Revin Roman http://phptime.ru
 */

namespace backend\modules\Account;

use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package backend\modules\Account
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
                'label' => \Yii::t('account', 'Accounts'),
                'url' => ['/account/list/index'],
                'icon' => FA::icon('user'),
                'visible' => User()->can(\backend\Permissions::ACCOUNT_ACCESS),
                'selected' => $Controller->module->id === 'account',
            ],
        ];
    }
}