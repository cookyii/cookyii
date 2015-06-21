<?php
/**
 * TemplateController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Postman\backend\controllers;

use cookyii\modules\Postman;

/**
 * Class TemplateController
 * @package cookyii\modules\Postman\backend\controllers
 */
class TemplateController extends Postman\backend\components\Controller
{

    /**
     * @inheritdoc
     */
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['list', 'edit'],
                'roles' => [Postman\backend\Permissions::POSTMAN_ACCESS],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionList()
    {
        return $this->render('list');
    }

    /**
     * @return string
     */
    public function actionEdit()
    {
        $TemplateEditForm = new Postman\backend\forms\TemplateEditForm([
            'Template' => new \resources\Postman\Template(),
        ]);

        return $this->render('edit', [
            'TemplateEditForm' => $TemplateEditForm,
        ]);
    }
}