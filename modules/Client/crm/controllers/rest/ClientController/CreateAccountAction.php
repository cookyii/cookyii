<?php
/**
 * CreateAccountAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\crm\controllers\rest\ClientController;

/**
 * Class CreateAccountAction
 * @package cookyii\modules\Client\crm\controllers\rest\ClientController
 */
class CreateAccountAction extends \yii\rest\Action
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

        $Account = $Client->accountHelper->create();

        if ($Account->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('client', 'Failed to create account'),
                'errors' => $Account->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('client', 'Account created successfully'),
                'account_id' => $Account->id,
            ];
        }

        return $result;
    }
}