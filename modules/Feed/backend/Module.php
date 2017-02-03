<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend;

use cookyii\Facade as F;
use cookyii\modules\Feed;
use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package cookyii\modules\Feed\backend
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
                'label' => \Yii::t('cookyii.feed', 'Feeds'),
                'url' => ['/feed/list/index'],
                'icon' => FA::icon('bars'),
                'visible' => F::User()->can(Feed\backend\Permissions::ACCESS),
                'selected' => $Controller->module->id === 'feed',
                'sort' => 1000,
            ],
        ];
    }
}