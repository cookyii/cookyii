<?php
/**
 * UserPropertyController.php
 * @author Revin Roman http://phptime.ru
 */

namespace backend\modules\Account\controllers\rest;

/**
 * Class UserPropertyController
 * @package backend\modules\Account\controllers\rest
 */
class UserPropertyController extends \yii\rest\Controller
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

        $user_id = (int)Request()->post('user_id');
        $key = str_clean(Request()->post('key'));
        $property = Request()->post('property', []);

        $property_key = str_clean(isset($property['key']) ? $property['key'] : null);
        $property_value = isset($property['value']) ? $property['value'] : null;

        if (empty($user_id)) {
            throw new \yii\web\BadRequestHttpException('Empty user id');
        }

        if (empty($property_key)) {
            throw new \yii\web\BadRequestHttpException('Empty property key');
        }

        /** @var \resources\User\Property|null $Property */
        $Property = null;

        if (!empty($key) && $key !== '__new') {
            $Property = \resources\User\Property::find()
                ->byUserId($user_id)
                ->byKey($key)
                ->one();
        }

        if ($key !== $property_key) {
            $exists = \resources\User\Property::find()
                ->byUserId($user_id)
                ->byKey($property_key)
                ->exists();

            if ($exists === true) {
                throw new \yii\web\BadRequestHttpException(sprintf('Property `%s` already exists', $property_key));
            }
        }

        if (empty($Property)) {
            $Property = new \resources\User\Property;
            $Property->user_id = $user_id;
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

        $user_id = (int)Request()->get('user_id');
        $key = str_clean(Request()->get('key'));

        if (empty($user_id)) {
            throw new \yii\web\BadRequestHttpException('Empty user id');
        }

        $Property = \resources\User\Property::find()
            ->byUserId($user_id)
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