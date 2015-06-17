<?php
/**
 * UserPropertyQuery.php
 * @author Revin Roman
 */

namespace resources\User\queries;

/**
 * Class UserPropertyQuery
 * @package resources\User\queries
 */
class UserPropertyQuery extends \yii\db\ActiveQuery
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
     * @param string|array $key
     * @return self
     */
    public function byKey($key)
    {
        $this->andWhere(['key' => $key]);

        return $this;
    }

    /**
     * @param string $value
     * @return self
     */
    public function byValue($value)
    {
        $this->andWhere(['like', 'value', $value]);

        return $this;
    }
}