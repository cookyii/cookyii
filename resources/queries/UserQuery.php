<?php
/**
 * UserQuery.php
 * @author Revin Roman
 */

namespace resources\queries;

use yii\helpers\ArrayHelper;

/**
 * Class UserQuery
 * @package resources\queries
 */
class UserQuery extends \yii\db\ActiveQuery
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
        /** @var \resources\User\Auth\queries\AbstractSocialQuery $SocialQuery */
        $SocialQuery = $class::find();

        /** @var \resources\User\Auth\AbstractSocial $Social */
        $Social = $SocialQuery
            ->bySocialId($social_id)
            ->one();

        if (empty($Social)) {
            return $this->andWhere('1=0');
        } else {
            $this->byId($Social->user_id);
        }

        return $this;
    }

    /**
     * @param integer|array $Facebook_id
     * @return self
     */
    public function byFacebookId($Facebook_id)
    {
        return $this->bySocialId('resources\User\Auth\Facebook', $Facebook_id);
    }

    /**
     * @param integer|array $Github_id
     * @return self
     */
    public function byGithubId($Github_id)
    {
        return $this->bySocialId('resources\User\Auth\Github', $Github_id);
    }

    /**
     * @param integer|array $Google_id
     * @return self
     */
    public function byGoogleId($Google_id)
    {
        return $this->bySocialId('resources\User\Auth\Google', $Google_id);
    }

    /**
     * @param integer|array $Linkedin_id
     * @return self
     */
    public function byLinkedinId($Linkedin_id)
    {
        return $this->bySocialId('resources\User\Auth\Linkedin', $Linkedin_id);
    }

    /**
     * @param integer|array $Live_id
     * @return self
     */
    public function byLiveId($Live_id)
    {
        return $this->bySocialId('resources\User\Auth\Live', $Live_id);
    }

    /**
     * @param integer|array $Twitter_id
     * @return self
     */
    public function byTwitterId($Twitter_id)
    {
        return $this->bySocialId('resources\User\Auth\Twitter', $Twitter_id);
    }


    /**
     * @param integer|array $Vkontakte_id
     * @return self
     */
    public function byVkontakteId($Vkontakte_id)
    {
        return $this->bySocialId('resources\User\Auth\Vkontakte', $Vkontakte_id);
    }

    /**
     * @param integer|array $Yandex_id
     * @return self
     */
    public function byYandexId($Yandex_id)
    {
        return $this->bySocialId('resources\User\Auth\Yandex', $Yandex_id);
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
     * @param integer|array $role
     * @return self
     */
    public function byRole($role)
    {
        switch ($role) {
            default:
                $this->withoutDeleted();

                $assignments = (new \yii\db\Query())
                    ->select('*')
                    ->from(AuthManager()->assignmentTable)
                    ->andWhere(['item_name' => $role])
                    ->all();

                $users_id = array_unique(ArrayHelper::getColumn($assignments, 'user_id'));
                if (empty($users_id)) {
                    $this->andWhere('1=0');
                } else {
                    $this->andWhere(['id' => $users_id]);
                }
                break;
            case 'deleted':
                $this->onlyDeleted();
                break;
            case 'all':
                $this->withoutDeleted();
                break;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function onlyDeleted()
    {
        $this->andWhere(['deleted' => \resources\User::DELETED]);

        return $this;
    }

    /**
     * @return self
     */
    public function withoutDeleted()
    {
        $this->andWhere(['deleted' => \resources\User::NOT_DELETED]);

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