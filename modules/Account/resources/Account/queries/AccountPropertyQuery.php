<?php
/**
 * AccountPropertyQuery.php
 * @author Revin Roman
 */

namespace resources\Account\queries;

/**
 * Class AccountPropertyQuery
 * @package resources\User\queries
 */
class AccountPropertyQuery extends \yii\db\ActiveQuery
{

    /**
     * @param integer|array $account_id
     * @return self
     */
    public function byAccountId($account_id)
    {
        $this->andWhere(['account_id' => $account_id]);

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