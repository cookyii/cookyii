<?php
/**
 * AccountController.php
 * @author Revin Roman
 */

namespace cookyii\modules\Page\backend\controllers\rest;

use cookyii\modules\Page;

/**
 * Class PageController
 * @package cookyii\modules\Page\backend\controllers\rest
 */
class PageController extends \yii\rest\ActiveController
{

    public $modelClass = 'resources\Page';

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        $verbs = parent::verbs();

        $verbs['edit'] = ['POST'];
        $verbs['roles'] = ['PUT'];
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
            'class' => Page\backend\controllers\rest\PageController\EditFormAction::className(),
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['detail'] = [
            'class' => Page\backend\controllers\rest\PageController\DetailAction::className(),
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

        $actions['restore'] = [
            'class' => \components\rest\actions\RestoreAction::className(),
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        return $actions;
    }

    /**
     * @inheritdoc
     */
    protected function serializeData($data)
    {
        return parent::serializeData($data);
    }

    /**
     * @param \yii\rest\Action $action
     * @return \yii\data\ActiveDataProvider
     */
    public function prepareListDataProvider($action)
    {
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $action->modelClass;

        /** @var \resources\queries\PageQuery $Query */
        $Query = $modelClass::find();

        $search = str_clean(Request()->get('search'));
        if (!empty($search)) {
            $Query->search($search);
        }

        $deleted = Request()->get('deleted');
        if ($deleted === 'false') {
            $Query->withoutDeleted();
        }

        return new \yii\data\ActiveDataProvider([
            'query' => $Query,
            'pagination' => ['pageSize' => 15],
        ]);
    }
}