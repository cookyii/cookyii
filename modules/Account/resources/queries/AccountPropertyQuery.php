<?php
/**
 * AccountPropertyQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\queries;

/**
 * Class AccountPropertyQuery
 * @package cookyii\modules\Account\resources\queries
 *
 * @method \cookyii\modules\Account\resources\AccountProperty|array|null one($db = null)
 * @method \cookyii\modules\Account\resources\AccountProperty[]|array all($db = null)
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