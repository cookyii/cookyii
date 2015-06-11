<?php
/**
 * SignController.php
 * @author Revin Roman http://phptime.ru
 */

namespace backend\modules\Account\controllers;

use backend\modules\Account;
use rmrevin\yii\rbac\RbacFactory;
use yii\helpers\Json;

/**
 * Class SignController
 * @package backend\modules\Account\controllers
 */
class SignController extends Account\components\Controller
{

    public $public = true;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
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
                ],
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

        $SignInForm = new Account\forms\SignInForm();

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
        $AuthResponse = new \resources\User\Auth\Response;
        $AuthResponse->client = $Client->getId();

        $attributes = $Client->getUserAttributes();
        $AuthResponse->response = Json::encode($attributes);

        $UserQuery = \resources\User::find();

        switch ($Client->getId()) {
            case 'facebook':
                $UserQuery->byFacebookId($attributes['id']);
                break;
            case 'github':
                $UserQuery->byGithubId($attributes['id']);
                break;
            case 'google':
                $UserQuery->byGoogleId($attributes['id']);
                break;
            case 'linkedin':
                $UserQuery->byLinkedinId($attributes['id']);
                break;
            case 'live':
                $UserQuery->byLiveId($attributes['id']);
                break;
            case 'twitter':
                $UserQuery->byTwitterId($attributes['id']);
                break;
            case 'vkontakte':
                $UserQuery->byVkontakteId($attributes['id']);
                break;
            case 'yandex':
                $UserQuery->byYandexId($attributes['id']);
                break;
        }

        /** @var \resources\User $User */
        $User = $UserQuery->one();

        if ($User instanceof \resources\User) {
            if (true !== ($reason = $User->isAvailable())) {
                switch ($reason) {
                    default:
                    case true:
                        break;
                    case 'not-activated':
                        $User->addError('activated', \Yii::t('account', 'Account is not activated.'));
                        break;
                    case 'deleted':
                        $User->addError('deleted', \Yii::t('account', 'Account removed.'));
                        break;
                }

                $AuthResponse->result = Json::encode($User->getErrors());
            } else {
                $AuthResponse->result = Json::encode($User->id);
            }
        } else {
            $User = new \resources\User();
            $User->appendClientAttributes($Client);

            if ($User->save()) {
                $User->createSocialLink($Client);

                $AuthResponse->result = Json::encode($User->id);

                AuthManager()->assign(RbacFactory::Role(\common\Roles::USER), $User->id);
            } else {
                $AuthResponse->result = Json::encode($User->getErrors());
            }
        }

        $AuthResponse->save();

        if ($User instanceof \resources\User && !$User->isNewRecord && !$User->hasErrors()) {
            $User->save();

            User()->login($User, 86400);
        } else {
            $errors = $User->getFirstErrors();

            if (isset($errors['activated'])) {
                throw new \yii\web\ForbiddenHttpException($errors['activated']);
            }

            if (isset($errors['deleted'])) {
                throw new \yii\web\ForbiddenHttpException($errors['deleted']);
            }
        }
    }
}