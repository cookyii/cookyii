<?php
/**
 * DefaultController.php
 * @author Alexander Volkov
 */

namespace cookyii\modules\Page\frontend\controllers;

use cookyii\modules\Page;

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
        $Page = \resources\Page::find()
            ->bySlug($slug)
            ->withoutDeactivated()
            ->withoutDeleted()
            ->one();

        if (!($Page instanceof \resources\Page)) {
            throw new \yii\web\NotFoundHttpException(\Yii::t('page', 'Страница не найдена'));
        }

        return $this->render('index', [
            'Page' => $Page
        ]);
    }
}