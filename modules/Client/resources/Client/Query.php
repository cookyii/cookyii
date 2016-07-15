<?php
/**
 * Query.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\resources\Client;

/**
 * Class Query
 * @package cookyii\modules\Client\resources\Client
 *
 * @method Model|array|null one($db = null)
 * @method Model[]|array all($db = null)
 */
class Query extends \yii\db\ActiveQuery
{

    use \cookyii\db\traits\query\DeletedQueryTrait;

    /**
     * @param integer|array $id
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
     * @param string|array $name
     * @return static
     */
    public function byName($name)
    {
        $this->andWhere(['name' => $name]);

        return $this;
    }

    /**
     * @param string|array $email
     * @return static
     */
    public function byEmail($email)
    {
        $this->andWhere(['email' => $email]);

        return $this;
    }

    /**
     * @param string|array $phone
     * @return static
     */
    public function byPhone($phone)
    {
        $this->andWhere(['phone' => $phone]);

        return $this;
    }

    /**
     * @param string $query
     * @return static
     */
    public function search($query)
    {
        $words = explode(' ', $query);

        $this->andWhere([
            'or',
            array_merge(['or'], array_map(function ($value) { return ['like', 'id', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'name', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'email', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'phone', $value]; }, $words)),
        ]);

        return $this;
    }
}
