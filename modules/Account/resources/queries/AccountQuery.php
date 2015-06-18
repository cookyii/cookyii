<?php
/**
 * AccountQuery.php
 * @author Revin Roman
 */

namespace resources\queries;

/**
 * Class AccountQuery
 * @package resources\queries
 */
class AccountQuery extends \yii\db\ActiveQuery
{

    /**
     * @param integer|array $id
     * @return self
     */
    public function byId($id)
    {
        $this->andWhere(['id' => $id]);

        return $this;
    }

    /**
     * @param string $class
     * @param integer|array $social_id
     * @return $this|static
     */
    public function bySocialId($class, $social_id)
    {
        /** @var \resources\Account\Auth\queries\AbstractSocialQuery $SocialQuery */
        $SocialQuery = $class::find();

        /** @var \resources\Account\Auth\AbstractSocial $Social */
        $Social = $SocialQuery
            ->bySocialId($social_id)
            ->one();

        if (empty($Social)) {
            return $this->andWhere('1=0');
        } else {
            $this->byId($Social->account_id);
        }

        return $this;
    }

    /**
     * @param integer|array $Facebook_id
     * @return self
     */
    public function byFacebookId($Facebook_id)
    {
        return $this->bySocialId('resources\Account\Auth\Facebook', $Facebook_id);
    }

    /**
     * @param integer|array $Github_id
     * @return self
     */
    public function byGithubId($Github_id)
    {
        return $this->bySocialId('resources\Account\Auth\Github', $Github_id);
    }

    /**
     * @param integer|array $Google_id
     * @return self
     */
    public function byGoogleId($Google_id)
    {
        return $this->bySocialId('resources\Account\Auth\Google', $Google_id);
    }

    /**
     * @param integer|array $Linkedin_id
     * @return self
     */
    public function byLinkedinId($Linkedin_id)
    {
        return $this->bySocialId('resources\Account\Auth\Linkedin', $Linkedin_id);
    }

    /**
     * @param integer|array $Live_id
     * @return self
     */
    public function byLiveId($Live_id)
    {
        return $this->bySocialId('resources\Account\Auth\Live', $Live_id);
    }

    /**
     * @param integer|array $Twitter_id
     * @return self
     */
    public function byTwitterId($Twitter_id)
    {
        return $this->bySocialId('resources\Account\Auth\Twitter', $Twitter_id);
    }


    /**
     * @param integer|array $Vkontakte_id
     * @return self
     */
    public function byVkontakteId($Vkontakte_id)
    {
        return $this->bySocialId('resources\Account\Auth\Vkontakte', $Vkontakte_id);
    }

    /**
     * @param integer|array $Yandex_id
     * @return self
     */
    public function byYandexId($Yandex_id)
    {
        return $this->bySocialId('resources\Account\Auth\Yandex', $Yandex_id);
    }

    /**
     * @param string|array $token
     * @return self
     */
    public function byToken($token)
    {
        $this->andWhere(['token' => $token]);

        return $this;
    }

    /**
     * @param string|array $name
     * @return self
     */
    public function byName($name)
    {
        $this->andWhere(['name' => $name]);

        return $this;
    }

    /**
     * @param string|array $email
     * @return self
     */
    public function byEmail($email)
    {
        $this->andWhere(['email' => $email]);

        return $this;
    }

    /**
     * @param string|array $login
     * @return self
     */
    public function byLogin($login)
    {
        $this->andWhere(['login' => $login]);

        return $this;
    }

    /**
     * @return self
     */
    public function onlyDeleted()
    {
        $this->andWhere(['deleted' => \resources\Account::DELETED]);

        return $this;
    }

    /**
     * @return self
     */
    public function withoutDeleted()
    {
        $this->andWhere(['deleted' => \resources\Account::NOT_DELETED]);

        return $this;
    }

    /**
     * @return self
     */
    public function withoutDeactivated()
    {
        $this->andWhere(['activated' => \resources\Account::ACTIVATED]);

        return $this;
    }

    /**
     * @param string $query
     * @return self
     */
    public function search($query)
    {
        $words = explode(' ', $query);

        $this->andWhere([
            'or',
            array_merge(['or'], array_map(function ($value) { return ['like', 'id', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'name', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'email', $value]; }, $words)),
        ]);

        return $this;
    }
} 