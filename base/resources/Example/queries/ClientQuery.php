<?php
/**
 * ClientQuery.php
 * @author Revin Roman http://phptime.ru
 */

namespace resources\Example\queries;

/**
 * Class ClientQuery
 * @package resources\Example\queries
 */
class ClientQuery extends \yii\db\ActiveQuery
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
}