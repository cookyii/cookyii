<?php
/**
 * DefaultController.php
 * @author Alexander Volkov
 */

namespace cookyii\modules\Page\frontend\controllers;

use cookyii\modules\Page;
use cookyii\modules\Page\resources\Page\Model as PageModel;

/**
 * Class DefaultController
 * @package cookyii\modules\Page\frontend\controllers
 */
class DefaultController extends Page\frontend\components\Controller
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
                'roles' => ['?', '@'],
            ],
        ];
    }

    /**
     * @param string $slug
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($slug)
    {
        /** @var PageModel $PageModel */
        $PageModel = \Yii::createObject(PageModel::class);

        $Page = $PageModel::find()
            ->bySlug($slug)
            ->withoutDeactivated()
            ->withoutDeleted()
            ->one();

        if (!($Page instanceof PageModel)) {
            throw new \yii\web\NotFoundHttpException(\Yii::t('cookyii.page', 'Page not found'));
        }

        return $this->render('index', [
            'Page' => $Page,
        ]);
    }
}
