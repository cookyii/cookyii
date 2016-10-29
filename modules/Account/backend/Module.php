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
class Module extends \yii\base\Module implements \cookyii\interfaces\BackendModuleInterface
{

    public $defaultRoute = 'sign/in';

    public $roles = [
        'admin' => \common\Roles::ADMIN,
        'user' => \common\Roles::USER,
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!isset($this->roles['admin']) || empty($this->roles['admin'])) {
            throw new Account\Exception(\Yii::t('app', 'Need configurate admin role in account module.'));
        }

        if (!isset($this->roles['user']) || empty($this->roles['user'])) {
            throw new Account\Exception(\Yii::t('app', 'Need configurate user role in account module.'));
        }
    }

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