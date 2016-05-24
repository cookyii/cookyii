<?php
/**
 * SocialAuthCallbackTrait.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\traits;

use rmrevin\yii\rbac\RbacFactory;
use yii\helpers\Json;

/**
 * Trait SocialAuthCallbackTrait
 * @package cookyii\modules\Account\traits
 */
trait SocialAuthCallbackTrait
{

    /**
     * @param \yii\authclient\ClientInterface $Client
     * @throws \yii\web\ForbiddenHttpException
     */
    public function socialAuthCallback(\yii\authclient\ClientInterface $Client)
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
            case 'instagram':
                $AccountQuery->byInstagramId($attributes['id']);
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
                        $Account->addError('activated', \Yii::t('cookyii.account', 'Account is not activated.'));
                        break;
                    case 'deleted':
                        $Account->addError('deleted', \Yii::t('cookyii.account', 'Account removed.'));
                        break;
                }

                $AuthResponse->result = Json::encode($Account->getErrors());
            } else {
                $AuthResponse->result = Json::encode($Account->id);
            }
        } else {
            $Account = $AccountModel;
            $Account->appendClientAttributes($Client);

            if (!empty($Account->email)) {
                $SearchAccount = $AccountModel::find()
                    ->byEmail($Account->email)
                    ->one();

                if (!empty($SearchAccount)) {
                    $Account = $SearchAccount;
                    $Account->appendClientAttributes($Client);
                }
            } else {
                Session()->set('OAuthResponseClient', $Client);

                Response()
                    ->redirect(['/account/sign/fill'])
                    ->send();

                exit;
            }

            $Account->activated_at = time();

            $Account->validate() && $Account->save(false);

            if ($Account->hasErrors()) {
                $AuthResponse->result = Json::encode($Account->getErrors());
            } else {
                $Account->pushSocialLink($Client);

                $AuthResponse->result = Json::encode($Account->id);

                if (!$Account->can(\common\Roles::USER)) {
                    AuthManager()->assign(RbacFactory::Role(\common\Roles::USER), $Account->id);
                }
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