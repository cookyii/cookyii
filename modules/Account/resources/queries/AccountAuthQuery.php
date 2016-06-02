<?php
/**
 * AccountAuthQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\queries;

/**
 * Class AccountAuthQuery
 * @package cookyii\modules\Account\resources\queries
 *
 * @method \cookyii\modules\Account\resources\AccountAuth|array|null one($db = null)
 * @method \cookyii\modules\Account\resources\AccountAuth[]|array all($db = null)
 */
class AccountAuthQuery extends \yii\db\ActiveQuery
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
     * @param string|array $social_type
     * @return static
     */
    public function bySocialType($social_type)
    {
        $this->andWhere(['social_type' => $social_type]);

        return $this;
    }

    /**
     * @param string|array $social_id
     * @return static
     */
    public function bySocialId($social_id)
    {
        $this->andWhere(['social_id' => $social_id]);

        return $this;
    }
}
