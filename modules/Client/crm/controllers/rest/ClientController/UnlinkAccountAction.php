<?php
/**
 * UnlinkAccountAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\crm\controllers\rest\ClientController;

/**
 * Class UnlinkAccountAction
 * @package cookyii\modules\Client\crm\controllers\rest\ClientController
 */
class UnlinkAccountAction extends \cookyii\rest\Action
{

    /**
     * @return array
     * @throws \yii\base\Exception
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        $client_id = (int)Request()->post('client_id');

        if (empty($client_id)) {
            throw new \yii\web\BadRequestHttpException;
        }

        /** @var \cookyii\modules\Client\resources\Client $Client */
        $Client = $this->findModel($client_id);

        if (!$Client->accountHelper->unlink()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('cookyii.client', 'Failed to unlink account'),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('cookyii.client', 'Account unlink successfully'),
            ];
        }

        return $result;
    }
}