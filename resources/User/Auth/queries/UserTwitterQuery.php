<?php
/**
 * UserTwitterQuery.php
 * @author Revin Roman
 */

namespace resources\User\Auth\queries;

/**
 * Class UserTwitterQuery
 * @package resources\User\Auth\queries
 */
class UserTwitterQuery extends AbstractSocialQuery
{

    /**
     * @param integer|array $user_id
     * @return self
     */
    public function byUserId($user_id)
    {
        $this->andWhere(['user_id' => $user_id]);

        return $this;
    }

    /**
     * @param integer|array $social_id
     * @return self
     */
    public function bySocialId($social_id)
    {
        $this->andWhere(['social_id' => $social_id]);

        return $this;
    }
}