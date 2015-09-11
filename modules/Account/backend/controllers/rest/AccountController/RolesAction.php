<?php
/**
 * RolesAction.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\backend\controllers\rest\AccountController;

use rmrevin\yii\rbac\RbacFactory;

/**
 * Class RolesAction
 * @package cookyii\modules\Account\backend\controllers\rest\AccountController
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

        $account_id = (int)Request()->post('account_id');
        $roles = (array)Request()->getBodyParam('roles', []);

        if (empty($account_id)) {
            throw new \yii\web\BadRequestHttpException('Empty account id');
        }

        /** @var \cookyii\modules\Account\resources\Account $Account */
        $Account = \cookyii\modules\Account\resources\Account::find()
            ->byId($account_id)
            ->one();

        if (empty($Account)) {
            throw new \yii\web\NotFoundHttpException('Account not found');
        }

        AuthManager()->revokeAll($Account->id);

        if (!empty($roles)) {
            foreach ($roles as $role => $flag) {
                if ($flag === true) {
                    AuthManager()->assign(RbacFactory::Role($role), $Account->id);
                }
            }
        }

        return [
            'result' => true,
            'message' => \Yii::t('account', 'Roles successfully saved.')
        ];
    }
}