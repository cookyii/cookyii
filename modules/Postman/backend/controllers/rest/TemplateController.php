<?php
/**
 * TemplateController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\backend\controllers\rest;

use cookyii\Facade as F;
use cookyii\modules\Postman;
use cookyii\modules\Postman\resources\PostmanTemplate\Model as PostmanTemplateModel;

/**
 * Class TemplateController
 * @package cookyii\modules\Postman\backend\controllers\rest
 */
class TemplateController extends \yii\rest\ActiveController
{

    public $modelClass = PostmanTemplateModel::class;

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        $verbs = parent::verbs();

        $verbs['edit'] = ['POST'];
        $verbs['detail'] = ['GET'];
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
            'class' => Postman\backend\controllers\rest\TemplateController\EditFormAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['detail'] = [
            'class' => Postman\backend\controllers\rest\TemplateController\DetailAction::class,
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

        return $actions;
    }

    /**
     * @param \yii\rest\Action $action
     * @return \yii\data\ActiveDataProvider
     */
    public function prepareListDataProvider($action)
    {
        /* @var $modelClass PostmanTemplateModel */
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
            'pagination' => ['pageSize' => 15],
        ]);
    }
}
