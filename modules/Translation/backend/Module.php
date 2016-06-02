<?php
/**
 * Module.php
 * @author Alexander Volkov
 */

namespace cookyii\modules\Translation\backend;

use rmrevin\yii\fontawesome\FA;

/**
 * Class Module
 * @package namespace cookyii\modules\Translation\backend
 */
class Module extends \yii\base\Module implements \cookyii\interfaces\BackendModuleInterface
{

    /** @var string */
    public $messagesConfig = '@base/messages/config.php';

    /**
     * @inheritdoc
     */
    public function menu($Controller)
    {
        return [
            [
                'label' => \Yii::t('cookyii.translation', 'Translation'),
                'url' => ['/translation/list/index'],
                'icon' => FA::icon('globe'),
                'visible' => User()->can(Permissions::ACCESS),
                'selected' => $Controller->module->id === 'translation',
                'sort' => 9000,
            ],
        ];
    }
}