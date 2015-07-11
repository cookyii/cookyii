<?php
/**
 * SectionController.php
 * @author Revin Roman
 */

namespace cookyii\modules\Feed\backend\controllers\section\rest;

use cookyii\modules\Feed;

/**
 * Class SectionController
 * @package cookyii\modules\Feed\backend\controllers\section\rest
 */
class SectionController extends \yii\rest\ActiveController
{

    public $modelClass = 'resources\Feed\Section';

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
            'class' => Feed\backend\controllers\section\rest\SectionController\EditFormAction::className(),
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['tree'] = [
            'class' => Feed\backend\controllers\section\rest\SectionController\TreeAction::className(),
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['detail'] = [
            'class' => Feed\backend\controllers\section\rest\SectionController\DetailAction::className(),
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['activate'] = [
            'class' => \components\rest\actions\ActivateAction::className(),
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['deactivate'] = [
            'class' => \components\rest\actions\DeactivateAction::className(),
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['delete'] = [
            'class' => \components\rest\actions\DeleteAction::className(),
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['restore'] = [
            'class' => \components\rest\actions\RestoreAction::className(),
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
     * @return \resources\Feed\Section the model found
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    public function findModel($id, $action)
    {
        /* @var $modelClass \resources\Feed\Section */
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
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $action->modelClass;

        /** @var \resources\Feed\queries\SectionQuery $Query */
        $Query = $modelClass::find();

        $search = str_clean(Request()->get('search'));
        if (!empty($search)) {
            $Query->search($search);
        }

        $deleted = Request()->get('deleted');
        if ($deleted === 'false') {
            $Query->withoutDeleted();
        }

        return new \components\data\CallableActiveDataProvider([
            'query' => $Query,
            'pagination' => ['pageSize' => 10000],
            'mapFunction' => function ($data) {
                $data['activated'] = !empty($data['activated_at']);
                $data['deleted'] = !empty($data['deleted_at']);

                return $data;
            }
        ]);
    }
}