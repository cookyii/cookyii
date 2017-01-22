<?php
/**
 * PropertyController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\backend\controllers\rest;

use cookyii\Decorator as D;
use cookyii\modules\Account;
use cookyii\modules\Account\resources\AccountProperty\Model as AccountPropertyModel;

/**
 * Class PropertyController
 * @package cookyii\modules\Account\backend\controllers\rest
 */
class PropertyController extends \cookyii\api\Controller
{

    /**
     * @inheritdoc
     */
    public function accessRules()
    {
        return [
            [
                'allow' => true,
                'roles' => [Account\backend\Permissions::ACCESS],
            ],
        ];
    }

    /**
     * @return array
     * @throws \yii\base\UserException
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionPush()
    {
        $result = [
            'result' => false,
            'message' => \Yii::t('cookyii', 'Unknown error'),
        ];

        $account_id = (int)D::Request()->post('account_id');
        $key = str_clean(D::Request()->post('key'));
        $property = D::Request()->post('property', []);

        $property_key = str_clean(isset($property['key']) ? $property['key'] : null);
        $property_value = isset($property['value']) ? $property['value'] : null;

        if (empty($account_id)) {
            throw new \yii\web\BadRequestHttpException('Empty account id');
        }

        if (empty($property_key)) {
            throw new \yii\web\BadRequestHttpException('Empty property key');
        }

        /** @var AccountPropertyModel $AccountPropertyModel */
        $AccountPropertyModel = \Yii::createObject(AccountPropertyModel::class);

        $Property = null;

        if (!empty($key) && $key !== '__new') {
            $Property = $AccountPropertyModel::find()
                ->byAccountId($account_id)
                ->byKey($key)
                ->one();
        }

        if ($key !== $property_key) {
            $exists = $AccountPropertyModel::find()
                ->byAccountId($account_id)
                ->byKey($property_key)
                ->exists();

            if ($exists === true) {
                throw new \yii\web\BadRequestHttpException(sprintf('Property `%s` already exists', $property_key));
            }
        }

        if (empty($Property)) {
            $Property = $AccountPropertyModel;
            $Property->account_id = $account_id;
        }

        $Property->key = $property_key;
        $Property->value = $property_value;

        $Property->validate() && $Property->save();

        if ($Property->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('cookyii', 'When executing a query the error occurred'),
                'errors' => $Property->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('cookyii.account', 'Property successfully saved'),
            ];
        }

        return $result;
    }

    /**
     * @return array
     * @throws \Exception
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete()
    {
        $result = [
            'result' => false,
            'message' => \Yii::t('cookyii', 'Unknown error'),
        ];

        $account_id = (int)D::Request()->get('account_id');
        $key = str_clean(D::Request()->get('key'));

        if (empty($account_id)) {
            throw new \yii\web\BadRequestHttpException('Empty account id');
        }

        /** @var AccountPropertyModel $AccountPropertyModel */
        $AccountPropertyModel = \Yii::createObject(AccountPropertyModel::class);

        $Property = $AccountPropertyModel::find()
            ->byAccountId($account_id)
            ->byKey($key)
            ->one();

        if (empty($Property)) {
            throw new \yii\web\NotFoundHttpException('Property not found');
        }

        if ($Property->delete() === false) {
            $result = [
                'result' => false,
                'message' => \Yii::t('cookyii.account', 'Unable to remove a property'),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('cookyii.account', 'Property was successfully removed'),
            ];
        }

        return $result;
    }
}
