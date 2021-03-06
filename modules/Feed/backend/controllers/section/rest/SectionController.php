<?php
/**
 * SectionController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\controllers\section\rest;

use cookyii\Facade as F;
use cookyii\modules\Feed;
use cookyii\modules\Feed\resources\FeedSection\Model as FeedSectionModel;

/**
 * Class SectionController
 * @package cookyii\modules\Feed\backend\controllers\section\rest
 */
class SectionController extends \cookyii\rest\Controller
{

    public $modelClass = FeedSectionModel::class;

    /**
     * @inheritdoc
     */
    public function accessRules()
    {
        return [
            [
                'allow' => true,
                'roles' => [Feed\backend\Permissions::ACCESS],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        $verbs = parent::verbs();

        $verbs['edit'] = ['POST'];
        $verbs['tree'] = ['GET'];
        $verbs['detail'] = ['GET'];
        $verbs['activate'] = ['POST'];
        $verbs['deactivate'] = ['POST'];
        $verbs['update'] = ['PUT'];
        $verbs['restore'] = ['PATCH'];

        return $verbs;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();

        $actions['edit'] = [
            'class' => Feed\backend\controllers\section\rest\SectionController\EditFormAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['tree'] = [
            'class' => Feed\backend\controllers\section\rest\SectionController\TreeAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['detail'] = [
            'class' => Feed\backend\controllers\section\rest\SectionController\DetailAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['activate'] = [
            'class' => \cookyii\rest\actions\ActivateAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['deactivate'] = [
            'class' => \cookyii\rest\actions\DeactivateAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['delete'] = [
            'class' => \cookyii\rest\actions\DeleteAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['restore'] = [
            'class' => \cookyii\rest\actions\RestoreAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['index']['prepareDataProvider'] = [$this, 'prepareListDataProvider'];
        $actions['delete']['findModel'] = [$this, 'findModel'];
        $actions['restore']['findModel'] = [$this, 'findModel'];

        return $actions;
    }

    public $findModel = [];

    /**
     * Returns the data model based on the primary key given.
     * If the data model is not found, a 404 HTTP exception will be raised.
     * @param string $id the ID of the model to be loaded. If the model has a composite primary key,
     * the ID must be a string of the primary key values separated by commas.
     * The order of the primary key values should follow that returned by the `primaryKey()` method
     * of the model.
     * @param $action
     * @return FeedSectionModel the model found
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    public function findModel($id, $action)
    {
        /* @var $modelClass FeedSectionModel */
        $modelClass = $this->modelClass;

        $model = $modelClass::find()
            ->bySlug($id)
            ->one();

        if (empty($model)) {
            throw new\yii\web\NotFoundHttpException("Object not found: $id");
        }

        return $model;
    }

    /**
     * @param \yii\rest\Action $action
     * @return \yii\data\ActiveDataProvider
     */
    public function prepareListDataProvider($action)
    {
        /* @var $modelClass FeedSectionModel */
        $modelClass = $action->modelClass;

        $Query = $modelClass::find();

        $search = str_clean(F::Request()->get('search'));
        if (!empty($search)) {
            $Query->search($search);
        }

        $deleted = F::Request()->get('deleted');
        if ($deleted === 'false') {
            $Query->withoutDeleted();
        }

        return new \yii\data\ActiveDataProvider([
            'query' => $Query,
            'pagination' => ['pageSize' => 10000],
        ]);
    }
}