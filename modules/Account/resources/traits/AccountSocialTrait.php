<?php
/**
 * AccountSocialTrait.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\traits;

use yii\helpers\Json;

/**
 * Trait AccountSocialTrait
 * @package cookyii\modules\Account\resources\traits
 *
 * @property integer $id
 */
trait AccountSocialTrait
{

    /**
     * @param \yii\authclient\ClientInterface $Client
     * @return bool
     * @throws \yii\web\ServerErrorHttpException
     */
    public function pushSocialLink(\yii\authclient\ClientInterface $Client)
    {
        $client = $Client->getId();
        $clients = \cookyii\modules\Account\resources\AbstractAccountAuth::getClientsList();

        if (!isset($clients[$client])) {
            throw new \yii\web\ServerErrorHttpException(\Yii::t('account', ''));
        }

        $attributes = $Client->getUserAttributes();

        $credentials = [
            'account_id' => $this->id,
            'social_id' => $attributes['id'],
        ];

        /** @var $class \cookyii\modules\Account\resources\AbstractAccountAuth */
        $class = $clients[$client];

        /** @var \cookyii\modules\Account\resources\queries\AccountAuthQuery $Query */
        $Query = $class::find();

        /** @var \cookyii\modules\Account\resources\AbstractAccountAuth $Auth */
        $Auth = $Query
            ->byAccountId($credentials['account_id'])
            ->bySocialId($credentials['social_id'])
            ->one();

        if (empty($Auth)) {
            $Auth = new $class($credentials);
        }

        if ($Client instanceof \yii\authclient\BaseOAuth) {
            $Auth->token = Json::encode($Client->getAccessToken()->getParams());
        }

        if (!empty($Auth)) {
            $Auth->save();
        }

        return $Auth;
    }

    /**
     * @param \yii\authclient\ClientInterface $Client
     * @throws \yii\base\NotSupportedException
     */
    public function appendClientAttributes(\yii\authclient\ClientInterface $Client)
    {
        $attributes = $Client->getUserAttributes();

        switch ($Client->getId()) {
            default:
                $attributes = null;
                break;
            case 'facebook':
                $attributes = $this->aggregateFacebookAttributes($attributes);
                break;
            case 'github':
                $attributes = $this->aggregateGithubAttributes($attributes);
                break;
            case 'google':
                $attributes = $this->aggregateGoogleAttributes($attributes);
                break;
            case 'linkedin':
                $attributes = $this->aggregateLinkedinAttributes($attributes);
                break;
            case 'live':
                $attributes = $this->aggregateLiveAttributes($attributes);
                break;
            case 'twitter':
                $attributes = $this->aggregateTwitterAttributes($attributes);
                break;
            case 'vkontakte':
                $attributes = $this->aggregateVkontakteAttributes($attributes);
                break;
            case 'yandex':
                $attributes = $this->aggregateYandexAttributes($attributes);
                break;
        }

        if (!empty($attributes)) {
            $this->setAttributes($attributes);
        }
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function aggregateFacebookAttributes(array $attributes)
    {
        $name = null;
        if (isset($attributes['name']) && !empty($attributes['name'])) {
            $name = $attributes['name'];
        }

        $email = null;
        if (isset($attributes['email']) && !empty($attributes['email'])) {
            $email = $attributes['email'];
        }

        return [
            'login' => $email,
            'name' => $name,
            'email' => $email,
        ];
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function aggregateGithubAttributes(array $attributes)
    {
        $name = $attributes['login'];
        if (isset($attributes['name']) && !empty($attributes['name'])) {
            $name = $attributes['name'];
        }

        $email = null;
        if (isset($attributes['email']) && !empty($attributes['email'])) {
            $email = $attributes['email'];
        }

        $avatar = null;
        if (isset($attributes['avatar_url']) && !empty($attributes['avatar_url'])) {
            $avatar = $attributes['avatar_url'];
        }

        return [
            'login' => $attributes['login'],
            'name' => $name,
            'email' => $email,
            'avatar' => $avatar,
        ];
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function aggregateGoogleAttributes(array $attributes)
    {
        $name = $attributes['displayName'];
        if (isset($attributes['name']['familyName']) && !empty($attributes['name']['familyName'])) {
            $name = $attributes['name']['familyName'] . ' ';
            if (isset($attributes['name']['givenName']) && !empty($attributes['name']['givenName'])) {
                $name .= $attributes['name']['givenName'];
            }
        }

        $email = null;
        if (isset($attributes['emails']) && !empty($attributes['emails'])) {
            $email = array_shift($attributes['emails'])['value'];
        }

        $avatar = null;
        if (isset($attributes['image']) && !empty($attributes['image'])) {
            $avatar = $attributes['image']['url'];
        }

        return [
            'login' => empty($email) ? ('google-' . $attributes['id']) : $email,
            'name' => trim($name),
            'email' => $email,
            'avatar' => $avatar,
        ];
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function aggregateLinkedinAttributes(array $attributes)
    {
        $name = null;
        if (isset($attributes['last_name']) && !empty($attributes['last_name'])) {
            $name = $attributes['last_name'] . ' ';
        }
        if (isset($attributes['first_name']) && !empty($attributes['first_name'])) {
            $name .= $attributes['first_name'];
        }

        $email = null;
        if (isset($attributes['email']) && !empty($attributes['email'])) {
            $email = $attributes['email'];
        }

        return [
            'login' => $email,
            'name' => trim($name),
            'email' => $email,
        ];
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function aggregateLiveAttributes(array $attributes)
    {
        $name = null;
        if (isset($attributes['last_name']) && !empty($attributes['last_name'])) {
            $name = $attributes['last_name'] . ' ';
        }
        if (isset($attributes['first_name']) && !empty($attributes['first_name'])) {
            $name .= $attributes['first_name'];
        }

        $email = null;
        if (isset($attributes['emails']) && !empty($attributes['emails'])) {
            if (isset($attributes['emails']['business']) && !empty($attributes['emails']['business'])) {
                $email = $attributes['emails']['business'];
            }
            if (isset($attributes['emails']['account']) && !empty($attributes['emails']['account'])) {
                $email = $attributes['emails']['account'];
            }
            if (isset($attributes['emails']['personal']) && !empty($attributes['emails']['personal'])) {
                $email = $attributes['emails']['personal'];
            }
        }

        return [
            'login' => $email,
            'name' => trim($name),
            'email' => $email,
        ];
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function aggregateTwitterAttributes(array $attributes)
    {
        $name = null;
        if (isset($attributes['name']) && !empty($attributes['name'])) {
            $name = $attributes['name'];
        }

        $avatar = null;
        if (isset($attributes['profile_image_url']) && !empty($attributes['profile_image_url'])) {
            $avatar = $attributes['profile_image_url'];
        }
        if (isset($attributes['profile_image_url_https']) && !empty($attributes['profile_image_url_https'])) {
            $avatar = $attributes['profile_image_url_https'];
        }

        return [
            'login' => $attributes['screen_name'],
            'name' => $name,
            'avatar' => $avatar,
        ];
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function aggregateVkontakteAttributes(array $attributes)
    {
        $name = null;
        if (isset($attributes['last_name']) && !empty($attributes['last_name'])) {
            $name = $attributes['last_name'] . ' ';
        }
        if (isset($attributes['first_name']) && !empty($attributes['first_name'])) {
            $name .= $attributes['first_name'];
        }

        $avatar = null;
        if (isset($attributes['photo']) && !empty($attributes['photo'])) {
            $avatar = $attributes['photo'];
        }

        return [
            'login' => $attributes['screen_name'],
            'name' => trim($name),
            'avatar' => $avatar,
        ];
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function aggregateYandexAttributes(array $attributes)
    {
        $name = null;
        if (isset($attributes['last_name']) && !empty($attributes['last_name'])) {
            $name = $attributes['last_name'] . ' ';
        }
        if (isset($attributes['first_name']) && !empty($attributes['first_name'])) {
            $name .= $attributes['first_name'];
        }
        if (isset($attributes['real_name']) && !empty($attributes['real_name'])) {
            $name = $attributes['real_name'];
        }

        $email = null;
        if (isset($attributes['default_email']) && !empty($attributes['default_email'])) {
            $email = $attributes['default_email'];
        }

        $avatar = null;
        // @todo implement yandex avatar $attributes['default_avatar_id']

        return [
            'login' => $attributes['login'],
            'name' => trim($name),
            'email' => $email,
        ];
    }
}