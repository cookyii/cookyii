<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Page\backend;

use cookyii\modules\Page;
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
                'label' => \Yii::t('cookyii.page', 'Pages'),
                'url' => ['/page/list/index'],
                'icon' => FA::icon('file'),
                'visible' => User()->can(Page\backend\Permissions::ACCESS),
                'selected' => $Controller->module->id === 'page',
                'sort' => 8000,
            ],
        ];
    }
}