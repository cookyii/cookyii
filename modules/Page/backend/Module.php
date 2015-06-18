<?php
/**
 * Module.php
 * @author Revin Roman
 */

namespace cookyii\modules\Page\backend;

use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package cookyii\modules\Page\backend
 */
class Module extends \yii\base\Module implements \backend\interfaces\BackendModuleInterface
{

    /**
     * @inheritdoc
     */
    public function menu($Controller)
    {
        return [
            [
                'label' => \Yii::t('account', 'Pages'),
                'url' => ['/page/list/index'],
                'icon' => FA::icon('file'),
                'visible' => User()->can(\backend\Permissions::PAGE_ACCESS),
                'selected' => $Controller->module->id === 'page',
            ],
        ];
    }
}