<?php
/**
 * EditFormAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\crm\controllers\rest\ClientController;

/**
 * Class EditFormAction
 * @package cookyii\modules\Client\crm\controllers\rest\ClientController
 */
class EditFormAction extends \cookyii\rest\Action
{

    /**
     * @return array
     */
    public function run()
    {
        $result = [
            'result' => false,
            'message' => \Yii::t('cookyii.client', 'Unknown error'),
        ];

        $client_id = (int)Request()->post('client_id');

        $Client = null;

        /** @var \cookyii\modules\Client\resources\Client $ClientModel */
        $ClientModel = \Yii::createObject(\cookyii\modules\Client\resources\Client::className());

        if ($client_id > 0) {
            $Client = $ClientModel::find()
                ->byId($client_id)
                ->one();
        }

        if (empty($Client)) {
            $Client = $ClientModel;
        }

        $ClientEditForm = \Yii::createObject([
            'class' => \cookyii\modules\Client\crm\forms\ClientEditForm::className(),
            'Client' => $Client,
        ]);

        $ClientEditForm->load(Request()->post())
        && $ClientEditForm->validate()
        && $ClientEditForm->save();

        if ($ClientEditForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('cookyii.client', 'When executing a query the error occurred'),
                'errors' => $ClientEditForm->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('cookyii.client', 'Client successfully saved'),
                'client_id' => $Client->id,
            ];
        }

        return $result;
    }
}