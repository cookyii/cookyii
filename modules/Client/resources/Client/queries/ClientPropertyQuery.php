<?php
/**
 * ClientPropertyQuery.php
 * @author Revin Roman
 */

namespace resources\Client\queries;

/**
 * Class ClientPropertyQuery
 * @package resources\Client\queries
 */
class ClientPropertyQuery extends \yii\db\ActiveQuery
{

    /**
     * @param integer|array $client_id
     * @return static
     */
    public function byClientId($client_id)
    {
        $this->andWhere(['client_id' => $client_id]);

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