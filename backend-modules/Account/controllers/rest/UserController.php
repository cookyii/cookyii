<?php
/**
 * UserController.php
 * @author Revin Roman
 */

namespace backend\modules\Account\controllers\rest;

use backend\modules\Account;

/**
 * Class UserController
 * @package backend\modules\Account\controllers\rest
 */
class UserController extends \yii\rest\ActiveController
{

    public $modelClass = 'resources\User';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = function ($action) {
            /* @var $modelClass \yii\db\BaseActiveRecord */
            $modelClass = $action->modelClass;

            /** @var \resources\queries\UserQuery $Query */
            $Query = $modelClass::find();

            $search = str_clean(Request()->get('search'));
            if (!empty($search)) {
                $Query->search($search);
            }

//            $Query->withoutDeleted();

            return new \yii\data\ActiveDataProvider([
                'query' => $Query,
                'pagination' => ['pageSize' => 15],
            ]);
        };

        $actions['restore'] = [
            'class' => 'common\rest\RestoreAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        return $actions;
    }

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        $verbs = parent::verbs();

        $verbs['update'] = ['PUT'];
        $verbs['restore'] = ['PATCH'];

        return $verbs;
    }
}