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
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['httpCache'] = [
            'class' => 'yii\filters\HttpCache',
            'only' => ['index'],
            'lastModified' => function ($action, $params) {
                return (new \yii\db\Query())
                    ->from('{{%user}}')
                    ->max('updated_at');
            }
        ];

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        $verbs = parent::verbs();

        $verbs['activate'] = ['POST'];
        $verbs['deactivate'] = ['POST'];
        $verbs['update'] = ['PUT'];
        $verbs['restore'] = ['PATCH'];
        $verbs['detail'] = ['GET'];

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
            'class' => 'backend\modules\Account\controllers\rest\UserController\EditFormAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['roles'] = [
            'class' => 'backend\modules\Account\controllers\rest\UserController\RolesAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['detail'] = [
            'class' => 'backend\modules\Account\controllers\rest\UserController\DetailAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['activate'] = [
            'class' => 'common\rest\ActivateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        $actions['deactivate'] = [
            'class' => 'common\rest\DeactivateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

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

        /** @var \resources\queries\UserQuery $Query */
        $Query = $modelClass::find();

        $role = str_clean(Request()->get('role'));
        switch ($role) {
            default:
            case 'all':
                break;
            case \common\Roles::USER:
                $Query->byRole(\common\Roles::USER);
                break;
            case \common\Roles::CLIENT:
                $Query->byRole(\common\Roles::CLIENT);
                break;
            case \common\Roles::MANAGER:
                $Query->byRole(\common\Roles::MANAGER);
                break;
            case \common\Roles::ADMIN:
                $Query->byRole(\common\Roles::ADMIN);
                break;

        }

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