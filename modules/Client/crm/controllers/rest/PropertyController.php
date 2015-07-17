<?php
/**
 * PropertyController.php
 * @author Revin Roman
 */

namespace cookyii\modules\Client\crm\controllers\rest;

/**
 * Class PropertyController
 * @package cookyii\modules\Client\crm\controllers\rest
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
            'message' => \Yii::t('client', 'Unknown error'),
        ];

        $client_id = (int)Request()->post('client_id');
        $key = str_clean(Request()->post('key'));
        $property = Request()->post('property', []);

        $property_key = str_clean(isset($property['key']) ? $property['key'] : null);
        $property_value = isset($property['value']) ? $property['value'] : null;

        if (empty($client_id)) {
            throw new \yii\web\BadRequestHttpException('Empty client id');
        }

        if (empty($property_key)) {
            throw new \yii\web\BadRequestHttpException('Empty property key');
        }

        /** @var \resources\Client\Property|null $Property */
        $Property = null;

        if (!empty($key) && $key !== '__new') {
            $Property = \resources\Client\Property::find()
                ->byClientId($client_id)
                ->byKey($key)
                ->one();
        }

        if ($key !== $property_key) {
            $exists = \resources\Client\Property::find()
                ->byClientId($client_id)
                ->byKey($property_key)
                ->exists();

            if ($exists === true) {
                throw new \yii\web\BadRequestHttpException(sprintf('Property `%s` already exists', $property_key));
            }
        }

        if (empty($Property)) {
            $Property = new \resources\Client\Property;
            $Property->client_id = $client_id;
        }

        $Property->key = $property_key;
        $Property->value = $property_value;

        $Property->validate() && $Property->save();

        if ($Property->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('client', 'When executing a query the error occurred'),
                'errors' => $Property->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('client', 'Property successfully saved'),
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
            'message' => \Yii::t('client', 'Unknown error'),
        ];

        $client_id = (int)Request()->get('client_id');
        $key = str_clean(Request()->get('key'));

        if (empty($client_id)) {
            throw new \yii\web\BadRequestHttpException('Empty client id');
        }

        /** @var \resources\Client\Property $Property */
        $Property = \resources\Client\Property::find()
            ->byClientId($client_id)
            ->byKey($key)
            ->one();

        if (empty($Property)) {
            throw new \yii\web\NotFoundHttpException('Property not found');
        }

        if ($Property->delete() === false) {
            $result = [
                'result' => false,
                'message' => \Yii::t('client', 'Unable to remove a property'),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('client', 'Property was successfully removed'),
            ];
        }

        return $result;
    }
}