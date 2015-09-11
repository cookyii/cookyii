<?php
/**
 * PropertyController.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\backend\controllers\rest;

/**
 * Class PropertyController
 * @package cookyii\modules\Account\backend\controllers\rest
 */
class PropertyController extends \yii\rest\Controller
{

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
            'message' => \Yii::t('account', 'Unknown error'),
        ];

        $account_id = (int)Request()->post('account_id');
        $key = str_clean(Request()->post('key'));
        $property = Request()->post('property', []);

        $property_key = str_clean(isset($property['key']) ? $property['key'] : null);
        $property_value = isset($property['value']) ? $property['value'] : null;

        if (empty($account_id)) {
            throw new \yii\web\BadRequestHttpException('Empty account id');
        }

        if (empty($property_key)) {
            throw new \yii\web\BadRequestHttpException('Empty property key');
        }

        /** @var \cookyii\modules\Account\resources\Account\Property|null $Property */
        $Property = null;

        if (!empty($key) && $key !== '__new') {
            $Property = \cookyii\modules\Account\resources\Account\Property::find()
                ->byAccountId($account_id)
                ->byKey($key)
                ->one();
        }

        if ($key !== $property_key) {
            $exists = \cookyii\modules\Account\resources\Account\Property::find()
                ->byAccountId($account_id)
                ->byKey($property_key)
                ->exists();

            if ($exists === true) {
                throw new \yii\web\BadRequestHttpException(sprintf('Property `%s` already exists', $property_key));
            }
        }

        if (empty($Property)) {
            $Property = new \cookyii\modules\Account\resources\Account\Property;
            $Property->account_id = $account_id;
        }

        $Property->key = $property_key;
        $Property->value = $property_value;

        $Property->validate() && $Property->save();

        if ($Property->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('account', 'When executing a query the error occurred'),
                'errors' => $Property->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('account', 'Property successfully saved'),
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
            'message' => \Yii::t('account', 'Unknown error'),
        ];

        $account_id = (int)Request()->get('account_id');
        $key = str_clean(Request()->get('key'));

        if (empty($account_id)) {
            throw new \yii\web\BadRequestHttpException('Empty account id');
        }

        /** @var \cookyii\modules\Account\resources\Account\Property $Property */
        $Property = \cookyii\modules\Account\resources\Account\Property::find()
            ->byAccountId($account_id)
            ->byKey($key)
            ->one();

        if (empty($Property)) {
            throw new \yii\web\NotFoundHttpException('Property not found');
        }

        if ($Property->delete() === false) {
            $result = [
                'result' => false,
                'message' => \Yii::t('account', 'Unable to remove a property'),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('account', 'Property was successfully removed'),
            ];
        }

        return $result;
    }
}