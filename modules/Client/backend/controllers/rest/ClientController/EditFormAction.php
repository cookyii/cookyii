<?php
/**
 * EditFormAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\backend\controllers\rest\ClientController;

use cookyii\Decorator as D;
use cookyii\modules\Client\resources\Client\Model as ClientModel;

/**
 * Class EditFormAction
 * @package cookyii\modules\Client\backend\controllers\rest\ClientController
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
            'message' => \Yii::t('cookyii', 'Unknown error'),
        ];

        $client_id = (int)D::Request()->post('client_id');

        $Client = null;

        /** @var ClientModel $ClientModel */
        $ClientModel = \Yii::createObject(ClientModel::class);

        if ($client_id > 0) {
            $Client = $ClientModel::find()
                ->byId($client_id)
                ->one();
        }

        if (empty($Client)) {
            $Client = $ClientModel;
        }

        $ClientEditForm = \Yii::createObject([
            'class' => \cookyii\modules\Client\backend\forms\ClientEditForm::class,
            'Client' => $Client,
        ]);

        $ClientEditForm->load(D::Request()->post())
        && $ClientEditForm->validate()
        && $ClientEditForm->save();

        if ($ClientEditForm->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('cookyii', 'When executing a query the error occurred'),
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