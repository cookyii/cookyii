<?php
/**
 * Query.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\Account;

use cookyii\modules\Account\resources\AccountAuth\Model as AccountAuthModel;

/**
 * Class Query
 * @package cookyii\modules\Account\resources\Account
 *
 * @method Model|array|null one($db = null)
 * @method Model[]|array all($db = null)
 */
class Query extends \yii\db\ActiveQuery
{

    use \cookyii\db\traits\query\ActivatedQueryTrait,
        \cookyii\db\traits\query\DeletedQueryTrait;

    /**
     * @param integer|array $id
     * @return static
     */
    public function byId($id)
    {
        $this->andWhere(['id' => $id]);

        return $this;
    }

    /**
     * @param integer|array $status
     * @return static
     */
    public function byStatus($status)
    {
        $this->andWhere(['status' => $status]);

        return $this;
    }

    /**
     * @param integer|array $facebook_user_id
     * @return static
     */
    public function byFacebookId($facebook_user_id)
    {
        return $this->bySocialId('facebook', $facebook_user_id);
    }

    /**
     * @param integer|array $instagram_user_id
     * @return static
     */
    public function byInstagramId($instagram_user_id)
    {
        return $this->bySocialId('instagram', $instagram_user_id);
    }

    /**
     * @param integer|array $github_user_id
     * @return static
     */
    public function byGithubId($github_user_id)
    {
        return $this->bySocialId('github', $github_user_id);
    }

    /**
     * @param integer|array $google_user_id
     * @return static
     */
    public function byGoogleId($google_user_id)
    {
        return $this->bySocialId('google', $google_user_id);
    }

    /**
     * @param integer|array $linkedin_user_id
     * @return static
     */
    public function byLinkedinId($linkedin_user_id)
    {
        return $this->bySocialId('linkedin', $linkedin_user_id);
    }

    /**
     * @param integer|array $live_user_id
     * @return static
     */
    public function byLiveId($live_user_id)
    {
        return $this->bySocialId('live', $live_user_id);
    }

    /**
     * @param integer|array $twitter_user_id
     * @return static
     */
    public function byTwitterId($twitter_user_id)
    {
        return $this->bySocialId('twitter', $twitter_user_id);
    }

    /**
     * @param integer|array $vkontakte_user_id
     * @return static
     */
    public function byVkontakteId($vkontakte_user_id)
    {
        return $this->bySocialId('vkontakte', $vkontakte_user_id);
    }

    /**
     * @param integer|array $yandex_user_id
     * @return static
     */
    public function byYandexId($yandex_user_id)
    {
        return $this->bySocialId('yandex', $yandex_user_id);
    }

    /**
     * @param integer|array $odnoklassniki_user_id
     * @return static
     */
    public function byOdnoklassnikiId($odnoklassniki_user_id)
    {
        return $this->bySocialId('odnoklassniki', $odnoklassniki_user_id);
    }

    /**
     * @param string|array $token
     * @return static
     */
    public function byToken($token)
    {
        $this->andWhere(['token' => $token]);

        return $this;
    }

    /**
     * @param string|array $name
     * @return static
     */
    public function byName($name)
    {
        $this->andWhere(['name' => $name]);

        return $this;
    }

    /**
     * @param string|array $email
     * @return static
     */
    public function byEmail($email)
    {
        $this->andWhere(['email' => $email]);

        return $this;
    }

    /**
     * @param string|array $login
     * @return static
     */
    public function byLogin($login)
    {
        $this->andWhere(['login' => $login]);

        return $this;
    }

    /**
     * @param string $query
     * @return static
     */
    public function search($query)
    {
        $words = explode(' ', $query);

        $this->andWhere([
            'or',
            array_merge(['or'], array_map(function ($value) {
                return ['like', 'id', $value];
            }, $words)),
            array_merge(['or'], array_map(function ($value) {
                return ['like', 'name', $value];
            }, $words)),
            array_merge(['or'], array_map(function ($value) {
                return ['like', 'email', $value];
            }, $words)),
        ]);

        return $this;
    }

    /**
     * @param string|array $social_type
     * @param string|array $social_id
     * @return $this|static
     */
    protected function bySocialId($social_type, $social_id)
    {
        /** @var $class AccountAuthModel */
        $Model = \Yii::createObject(AccountAuthModel::class);

        $Social = $Model::find()
            ->bySocialType($social_type)
            ->bySocialId($social_id)
            ->one();

        if (empty($Social)) {
            return $this->andWhere('1=0');
        } else {
            $this->byId($Social->account_id);
        }

        return $this;
    }
}
