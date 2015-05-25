<?php
/**
 * OrderQuery.php
 * @author Revin Roman http://phptime.ru
 */

namespace resources\Example\queries;

/**
 * Class OrderQuery
 * @package resources\Example\queries
 */
class OrderQuery extends \yii\db\ActiveQuery
{

    /**
     * @param integer|array $id
     * @return self
     */
    public function byId($id)
    {
        $this->andWhere(['id' => $id]);

        return $this;
    }

    /**
     * @param integer|array $client_id
     * @return self
     */
    public function byClientId($client_id)
    {
        $this->andWhere(['client_id' => $client_id]);

        return $this;
    }
}