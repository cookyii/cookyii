<?php
/**
 * AbstractSocialQuery.php
 * @author Revin Roman
 */

namespace resources\User\Auth\queries;

/**
 * Interface AbstractSocialQuery
 * @package resources\User\Auth\queries
 */
abstract class AbstractSocialQuery extends \yii\db\Query
{

    /**
     * @param integer|array $user_id
     * @return self
     */
    abstract public function byUserId($user_id);

    /**
     * @param integer|array $social_id
     * @return self
     */
    abstract public function bySocialId($social_id);
}