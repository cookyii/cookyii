<?php
/**
 * EditFormAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\controllers\rest\TemplateController;

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
            'message' => \Yii::t('postman', 'Unknown error'),
        ];

        $template_id = (int)Request()->post('template_id');

        /** @var $modelClass \cookyii\modules\Postman\resources\Postman\Template */
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

        $TemplateEditForm = new Postman\backend\forms\TemplateEditForm(['Template' => $Template]);

        $TemplateEditForm->load(Request()->post())
        && $TemplateEditForm->validate()
        && $TemplateEditForm->save();

        if ($TemplateEditForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('postman', 'When executing a query the error occurred'),
                'errors' => $TemplateEditForm->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('postman', 'Template successfully saved'),
                'template_id' => $Template->id,
            ];
        }

        return $result;
    }
}