<?php
/**
 * AccountPropertyQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\Account\queries;

/**
 * Class AccountPropertyQuery
 * @package cookyii\modules\Account\resources\Account\queries
 */
class AccountPropertyQuery extends \yii\db\ActiveQuery
{

    /**
     * @param integer|array $account_id
     * @return static
     */
    public function byAccountId($account_id)
    {
        $this->andWhere(['account_id' => $account_id]);

        return $this;
    }

    /**
     * @param string|array $key
     * @return static
     */
    public function byKey($key)
    {
        $this->andWhere(['key' => $key]);

        return $this;
    }

    /**
     * @param string $value
     * @return static
     */
    public function byValue($value)
    {
        $this->andWhere(['like', 'value', $value]);

        return $this;
    }
}