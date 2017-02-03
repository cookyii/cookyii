<?php
/**
 * EditFormAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\controllers\rest\TemplateController;

use cookyii\Facade as F;
use cookyii\modules\Postman;

/**
 * Class EditFormAction
 * @package cookyii\modules\Postman\backend\controllers\rest\TemplateController
 */
class EditFormAction extends \cookyii\rest\Action
{

    /**
     * @return array
     */
    public function run()
    {
        $result = [
            'result' => false,
            'message' => \Yii::t('cookyii', 'Unknown error'),
        ];

        $template_id = (int)F::Request()->post('template_id');

        /** @var $modelClass \cookyii\modules\Postman\resources\PostmanTemplate\Model */
        $modelClass = $this->modelClass;

        $Template = null;

        if ($template_id > 0) {
            $Template = $modelClass::find()
                ->byId($template_id)
                ->one();
        }

        if (empty($Template)) {
            $Template = new $modelClass;
        }

        $TemplateEditForm = \Yii::createObject([
            'class' => Postman\backend\forms\TemplateEditForm::class,
            'Template' => $Template,
        ]);

        $TemplateEditForm->load(F::Request()->post())
        && $TemplateEditForm->validate()
        && $TemplateEditForm->save();

        if ($TemplateEditForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('cookyii', 'When executing a query the error occurred'),
                'errors' => $TemplateEditForm->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('cookyii.postman', 'Template successfully saved'),
                'template_id' => $Template->id,
            ];
        }

        return $result;
    }
}