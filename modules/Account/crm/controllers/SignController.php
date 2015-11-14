<?php
/**
 * SignController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\crm\controllers;

use cookyii\modules\Account;
use rmrevin\yii\rbac\RbacFactory;
use yii\helpers\Json;

/**
 * Class SignController
 * @package cookyii\modules\Account\crm\controllers
 */
class SignController extends Account\crm\components\Controller
{

    public $public = true;

    /**
     * @inheritdoc
     */
    protected function accessRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['in', 'auth'],
                'roles' => ['?', '@'],
            ],
            [
                'allow' => true,
                'actions' => ['out'],
                'roles' => ['@'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'authSuccessCallback'],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIn()
    {
        if (!User()->isGuest) {
            return $this->redirect(['/']);
        }

        $this->layout = '//wide';

        $SignInForm = \Yii::createObject(Account\crm\forms\SignInForm::className());

        return $this->render('in', [
            'SignInForm' => $SignInForm,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionOut()
    {
        User()->logout();

        return $this->goHome();
    }

    /**
     * @param \yii\authclient\ClientInterface $Client
     * @throws \yii\web\ForbiddenHttpException
     */
    public function authSuccessCallback(\yii\authclient\ClientInterface $Client)
    {
        $AuthResponse = \cookyii\modules\Account\resources\AccountAuthResponse::createLog($Client);

        $attributes = $Client->getUserAttributes();

        /** @var \cookyii\modules\Account\resources\Account $AccountModel */
        $AccountModel = \Yii::createObject(\cookyii\modules\Account\resources\Account::className());

        $AccountQuery = $AccountModel::find();

        switch ($Client->getId()) {
            case 'facebook':
                $AccountQuery->byFacebookId($attributes['id']);
                break;
            case 'github':
                $AccountQuery->byGithubId($attributes['id']);
                break;
            case 'google':
                $AccountQuery->byGoogleId($attributes['id']);
                break;
            case 'linkedin':
                $AccountQuery->byLinkedinId($attributes['id']);
                break;
            case 'live':
                $AccountQuery->byLiveId($attributes['id']);
                break;
            case 'twitter':
                $AccountQuery->byTwitterId($attributes['id']);
                break;
            case 'vkontakte':
                $AccountQuery->byVkontakteId($attributes['id']);
                break;
            case 'yandex':
                $AccountQuery->byYandexId($attributes['id']);
                break;
        }

        $Account = $AccountQuery->one();

        if ($Account instanceof \cookyii\modules\Account\resources\Account) {
            $Account->pushSocialLink($Client);

            if (true !== ($reason = $Account->isAvailable())) {
                switch ($reason) {
                    default:
                    case true:
                        break;
                    case 'not-activated':
                        $Account->addError('activated', \Yii::t('account', 'Account is not activated.'));
                        break;
                    case 'deleted':
                        $Account->addError('deleted', \Yii::t('account', 'Account removed.'));
                        break;
                }

                $AuthResponse->result = Json::encode($Account->getErrors());
            } else {
                $AuthResponse->result = Json::encode($Account->id);
            }
        } else {
            $Account = $AccountModel;
            $Account->appendClientAttributes($Client);

            if ($Account->save()) {
                $Account->pushSocialLink($Client);

                $AuthResponse->result = Json::encode($Account->id);

                AuthManager()->assign(RbacFactory::Role(\common\Roles::USER), $Account->id);
            } else {
                $AuthResponse->result = Json::encode($Account->getErrors());
            }
        }

        $AuthResponse->validate() && $AuthResponse->save();

        if ($Account instanceof \cookyii\modules\Account\resources\Account && !$Account->isNewRecord && !$Account->hasErrors()) {
            $Account->save();

            User()->login($Account, 86400);
        } else {
            $errors = $Account->getFirstErrors();

            if (isset($errors['activated'])) {
                throw new \yii\web\ForbiddenHttpException($errors['activated']);
            }

            if (isset($errors['deleted'])) {
                throw new \yii\web\ForbiddenHttpException($errors['deleted']);
            }
        }
    }
}