<?php
/**
 * MessageController.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\modules\Postman\backend\controllers\rest;

use cookyii\modules\Postman;
use yii\helpers\Json;

/**
 * Class MessageController
 * @package cookyii\modules\Postman\backend\controllers\rest
 */
class MessageController extends \yii\rest\ActiveController
{

    public $modelClass = 'resources\Postman\Message';

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        $verbs = parent::verbs();

        $verbs['edit'] = ['POST'];
        $verbs['detail'] = ['GET'];
        $verbs['update'] = ['PUT'];
        $verbs['resent'] = ['PUT'];
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
            'class' => Postman\backend\controllers\rest\MessageController\EditFormAction::className(),
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['detail'] = [
            'class' => Postman\backend\controllers\rest\MessageController\DetailAction::className(),
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['resent'] = [
            'class' => Postman\backend\controllers\rest\MessageController\ResentAction::className(),
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['delete'] = [
            'class' => \cookyii\rest\actions\DeleteAction::className(),
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['restore'] = [
            'class' => \cookyii\rest\actions\RestoreAction::className(),
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

        /** @var \resources\queries\AccountQuery $Query */
        $Query = $modelClass::find();

        $search = str_clean(Request()->get('search'));
        if (!empty($search)) {
            $Query->search($search);
        }

        $deleted = Request()->get('deleted');
        if ($deleted === 'false') {
            $Query->withoutDeleted();
        }

        return new \cookyii\data\CallableActiveDataProvider([
            'query' => $Query,
            'pagination' => ['pageSize' => 15],
            'mapFunction' => function ($data) {
                $data['address'] = !empty($data['address']) ? Json::decode($data['address']) : [];
                $data['deleted'] = !empty($data['deleted_at']);

                return $data;
            }
        ]);
    }
}