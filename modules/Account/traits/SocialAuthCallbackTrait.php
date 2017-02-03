<?php
/**
 * SocialAuthCallbackTrait.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\traits;

use cookyii\Facade as F;
use cookyii\modules\Account;
use cookyii\modules\Account\resources\Account\Model as AccountModel;
use cookyii\modules\Account\resources\AccountAuthResponse\Model as AccountAuthResponseModel;
use rmrevin\yii\rbac\RbacFactory;
use yii\helpers\Json;

/**
 * Trait SocialAuthCallbackTrait
 * @package cookyii\modules\Account\traits
 */
trait SocialAuthCallbackTrait
{

    public $accountModule = 'account';

    /**
     * @param \yii\authclient\ClientInterface $Client
     * @throws \yii\web\ForbiddenHttpException
     */
    public function socialAuthCallback(\yii\authclient\ClientInterface $Client)
    {
        $cookie_expire = property_exists($this, 'cookieExpire')
            ? $this->cookieExpire
            : 0;

        /** @var Account\backend\Module $Module */
        $Module = \Yii::$app->getModule($this->accountModule);
        $roles = $Module->roles;

        $AuthResponse = AccountAuthResponseModel::createLog($Client);

        $attributes = $Client->getUserAttributes();

        /** @var AccountModel $AccountModel */
        $AccountModel = \Yii::createObject(AccountModel::class);

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
            case 'odnoklassniki':
                $AccountQuery->byOdnoklassnikiId($attributes['id']);
                break;
        }

        $Account = $AccountQuery->one();

        if ($Account instanceof AccountModel) {
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
            }

            $Account->activated_at = time();

            $Account->validate() && $Account->save(false);

            if ($Account->hasErrors()) {
                $AuthResponse->result = Json::encode($Account->getErrors());
            } else {
                $Account->pushSocialLink($Client);

                $AuthResponse->result = Json::encode($Account->id);

                if (!$Account->can($roles['user'])) {
                    F::AuthManager()->assign(RbacFactory::Role($roles['user']), $Account->id);
                }
            }
        }

        $AuthResponse->validate() && $AuthResponse->save();

        if ($Account instanceof AccountModel && !$Account->isNewRecord && !$Account->hasErrors()) {
            $Account->save();

            F::User()->login($Account, $cookie_expire);
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
