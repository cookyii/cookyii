<?php
/**
 * SignController.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\frontend\controllers;

use cookyii\modules\Account;
use rmrevin\yii\rbac\RbacFactory;
use yii\helpers\Json;

/**
 * Class SignController
 * @package cookyii\modules\Account\frontend\controllers
 */
class SignController extends Account\frontend\components\Controller
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
                'actions' => ['in', 'up', 'auth'],
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

        $SignInForm = new Account\frontend\forms\SignInForm();

        return $this->render('in', [
            'SignInForm' => $SignInForm,
        ]);
    }

    /**
     * @return string
     */
    public function actionUp()
    {
        if (!User()->isGuest) {
            return $this->redirect(['/']);
        }

        $this->layout = '//wide';

        $SignUpForm = new Account\frontend\forms\SignUpForm();

        return $this->render('up', [
            'SignUpForm' => $SignUpForm,
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
        $AuthResponse = new \resources\Account\Auth\Response;
        $AuthResponse->client = $Client->getId();

        $attributes = $Client->getUserAttributes();
        $AuthResponse->response = Json::encode($attributes);

        $AccountQuery = \resources\Account::find();

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

        /** @var \resources\Account $Account */
        $Account = $AccountQuery->one();

        if ($Account instanceof \resources\Account) {
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
            $Account = new \resources\Account();
            $Account->appendClientAttributes($Client);

            if ($Account->save()) {
                $Account->createSocialLink($Client);

                $AuthResponse->result = Json::encode($Account->id);

                AuthManager()->assign(RbacFactory::Role(\common\Roles::USER), $Account->id);
            } else {
                $AuthResponse->result = Json::encode($Account->getErrors());
            }
        }

        $AuthResponse->save();

        if ($Account instanceof \resources\Account && !$Account->isNewRecord && !$Account->hasErrors()) {
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