<?php
/**
 * RolesAction.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\backend\controllers\rest\UserController;

use rmrevin\yii\rbac\RbacFactory;

/**
 * Class RolesAction
 * @package cookyii\modules\Account\backend\controllers\rest\UserController
 */
class RolesAction extends \yii\rest\Action
{

    /**
     * @return array
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        $result = [
            'result' => false,
            'message' => \Yii::t('account', 'Unknown error'),
        ];

        $user_id = (int)Request()->post('user_id');
        $roles = (array)Request()->getBodyParam('roles', []);

        if (empty($user_id)) {
            throw new \yii\web\BadRequestHttpException('Empty user id');
        }

        /** @var \resources\User $User */
        $User = \resources\User::find()
            ->byId($user_id)
            ->one();

        if (empty($User)) {
            throw new \yii\web\NotFoundHttpException('User not found');
        }

        AuthManager()->revokeAll($User->id);

        if (!empty($roles)) {
            foreach ($roles as $role => $flag) {
                if ($flag === true) {
                    AuthManager()->assign(RbacFactory::Role($role), $User->id);
                }
            }
        }

        return [
            'result' => true,
            'message' => \Yii::t('account', 'Roles successfully saved.')
        ];
    }
}