<?php
/**
 * EditFormAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\crm\controllers\rest\ClientController;

use cookyii\modules\Client;

/**
 * Class EditFormAction
 * @package cookyii\modules\Client\crm\controllers\rest\ClientController
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
            'message' => \Yii::t('client', 'Unknown error'),
        ];

        $client_id = (int)Request()->post('client_id');

        /** @var \cookyii\modules\Client\resources\Client|null $Client */
        $Client = null;

        if ($client_id > 0) {
            $Client = \cookyii\modules\Client\resources\Client::find()
                ->byId($client_id)
                ->one();
        }

        if (empty($Client)) {
            $Client = new \cookyii\modules\Client\resources\Client();
        }

        $ClientEditForm = new Client\crm\forms\ClientEditForm(['Client' => $Client]);

        $ClientEditForm->load(Request()->post())
        && $ClientEditForm->validate()
        && $ClientEditForm->save();

        if ($ClientEditForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('client', 'When executing a query the error occurred'),
                'errors' => $ClientEditForm->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('client', 'Client successfully saved'),
                'client_id' => $Client->id,
            ];
        }

        return $result;
    }
}