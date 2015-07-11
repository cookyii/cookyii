<?php
/**
 * ItemController.php
 * @author Revin Roman
 */

namespace cookyii\modules\Feed\backend\controllers\item\rest;

use cookyii\modules\Feed;

/**
 * Class ItemController
 * @package cookyii\modules\Feed\backend\controllers\item\rest
 */
class ItemController extends \yii\rest\ActiveController
{

    public $modelClass = 'resources\Feed\Item';

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        $verbs = parent::verbs();

        $verbs['edit'] = ['POST'];
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

        $actions['index']['prepareDataProvider'] = [$this, 'prepareListDataProvider'];

        $actions['edit'] = [
            'class' => Feed\backend\controllers\item\rest\ItemController\EditFormAction::className(),
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['detail'] = [
            'class' => Feed\backend\controllers\item\rest\ItemController\DetailAction::className(),
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

        return $actions;
    }

    /**
     * @param \yii\rest\Action $action
     * @return \yii\data\ActiveDataProvider
     */
    public function prepareListDataProvider($action)
    {
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $action->modelClass;

        /** @var \resources\Feed\queries\ItemQuery $Query */
        $Query = $modelClass::find();

        $section = str_clean(Request()->get('section'));
        if (!empty($section)) {
            $Query->bySectionSlug($section);
        }

        $search = str_clean(Request()->get('search'));
        if (!empty($search)) {
            $Query->search($search);
        }

        $deleted = Request()->get('deleted');
        if ($deleted === 'false') {
            $Query->withoutDeleted();
        }

        $Query->orderBy(['sort' => SORT_DESC]);

        return new \components\data\CallableActiveDataProvider([
            'query' => $Query,
            'pagination' => ['pageSize' => 10],
            'mapFunction' => function ($data) {
                $data['activated'] = !empty($data['activated_at']);
                $data['deleted'] = !empty($data['deleted_at']);

                return $data;
            }
        ]);
    }
}