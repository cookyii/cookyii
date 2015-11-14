<?php
/**
 * AccountQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\queries;

use cookyii\modules\Account;

/**
 * Class AccountQuery
 * @package cookyii\modules\Account\resources\queries
 *
 * @method \cookyii\modules\Account\resources\Account|array|null one($db = null)
 * @method \cookyii\modules\Account\resources\Account[]|array all($db = null)
 */
class AccountQuery extends \yii\db\ActiveQuery
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
     * @param integer|array $Facebook_id
     * @return static
     */
    public function byFacebookId($Facebook_id)
    {
        return $this->bySocialId('facebook', $Facebook_id);
    }

    /**
     * @param integer|array $Github_id
     * @return static
     */
    public function byGithubId($Github_id)
    {
        return $this->bySocialId('github', $Github_id);
    }

    /**
     * @param integer|array $Google_id
     * @return static
     */
    public function byGoogleId($Google_id)
    {
        return $this->bySocialId('google', $Google_id);
    }

    /**
     * @param integer|array $Linkedin_id
     * @return static
     */
    public function byLinkedinId($Linkedin_id)
    {
        return $this->bySocialId('linkedin', $Linkedin_id);
    }

    /**
     * @param integer|array $Live_id
     * @return static
     */
    public function byLiveId($Live_id)
    {
        return $this->bySocialId('live', $Live_id);
    }

    /**
     * @param integer|array $Twitter_id
     * @return static
     */
    public function byTwitterId($Twitter_id)
    {
        return $this->bySocialId('twitter', $Twitter_id);
    }

    /**
     * @param integer|array $Vkontakte_id
     * @return static
     */
    public function byVkontakteId($Vkontakte_id)
    {
        return $this->bySocialId('vkontakte', $Vkontakte_id);
    }

    /**
     * @param integer|array $Yandex_id
     * @return static
     */
    public function byYandexId($Yandex_id)
    {
        return $this->bySocialId('yandex', $Yandex_id);
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
     * @param string $client
     * @param integer|array $social_id
     * @return $this|static
     */
    protected function bySocialId($client, $social_id)
    {
        $clients = Account\resources\AbstractAccountAuth::getClientsList();

        /** @var $class \cookyii\modules\Account\resources\AbstractAccountAuth */
        $class = $clients[$client];

        $Social = $class::find()
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