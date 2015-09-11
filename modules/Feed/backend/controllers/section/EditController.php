<?php
/**
 * EditController.php
 * @author Revin Roman
 */

namespace cookyii\modules\Feed\backend\controllers\section;

use cookyii\modules\Feed;

/**
 * Class EditController
 * @package cookyii\modules\Feed\backend\controllers\section
 */
class EditController extends Feed\backend\components\Controller
{

    /**
     * @inheritdoc
     */
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => [Feed\backend\Permissions::ACCESS],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $SectionEditForm = new Feed\backend\forms\SectionEditForm([
            'Section' => new \cookyii\modules\Feed\resources\Feed\Section(),
        ]);

        return $this->render('index', [
            'SectionEditForm' => $SectionEditForm,
        ]);
    }
}