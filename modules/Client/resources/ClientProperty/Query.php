<?php
/**
 * Query.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\resources\ClientProperty;

/**
 * Class Query
 * @package cookyii\modules\Client\resources\ClientProperty
 *
 * @method Model|array|null one($db = null)
 * @method Model[]|array all($db = null)
 */
class Query extends \yii\db\ActiveQuery
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
