<?php
/**
 * AbstractAccountAuthQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\queries;

/**
 * Interface AbstractAccountAuthQuery
 * @package cookyii\modules\Account\resources\queries
 */
abstract class AbstractAccountAuthQuery extends \yii\db\ActiveQuery
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
     * @param integer|array $social_id
     * @return static
     */
    public function bySocialId($social_id)
    {
        $this->andWhere(['social_id' => $social_id]);

        return $this;
    }
}