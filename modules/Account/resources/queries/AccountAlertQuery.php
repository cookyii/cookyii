<?php
/**
 * AccountAlertQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\queries;

/**
 * Class AccountAlertQuery
 * @package cookyii\modules\Account\resources\queries
 *
 * @method \cookyii\modules\Account\resources\AccountAlert|array|null one($db = null)
 * @method \cookyii\modules\Account\resources\AccountAlert[]|array all($db = null)
 */
class AccountAlertQuery extends \yii\db\ActiveQuery
{
    
    use \cookyii\db\traits\query\DeletedQueryTrait;

    /**
     * @param string|array $id
     * @return static
     */
    public function byId($id)
    {
        $this->andWhere(['id' => $id]);

        return $this;
    }

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
     * @param integer $timestamp
     * @return static
     */
    public function createdAfter($timestamp)
    {
        $this->andWhere(['>', 'created_at', $timestamp]);

        return $this;
    }

    /**
     * @param string $text
     * @return static
     */
    public function byMessage($text)
    {
        $this->andWhere(['message' => $text]);

        return $this;
    }
}