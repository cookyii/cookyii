<?php
/**
 * EditFormAction.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\backend\controllers\rest\UserController;

use cookyii\modules\Account;

/**
 * Class EditFormAction
 * @package cookyii\modules\Account\backend\controllers\rest\UserController
 */
class EditFormAction extends \yii\rest\Action
{

    /**
     * @return array
     */
    public function run()
    {
        $result = [
            'result' => false,
            'message' => \Yii::t('account', 'Unknown error'),
        ];

        $user_id = (int)Request()->post('user_id');

        /** @var \resources\User|null $User */
        $User = null;

        if ($user_id > 0) {
            $User = \resources\User::find()
                ->byId($user_id)
                ->one();
        }

        if (empty($User)) {
            $User = new \resources\User();
        }

        $AccountEditForm = new Account\backend\forms\AccountEditForm(['User' => $User]);

        $AccountEditForm->load(Request()->post())
        && $AccountEditForm->validate()
        && $AccountEditForm->save();

        if ($AccountEditForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('account', 'When executing a query the error occurred'),
                'errors' => $AccountEditForm->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('account', 'Account successfully saved'),
                'account_id' => $User->id,
            ];
        }

        return $result;
    }
}