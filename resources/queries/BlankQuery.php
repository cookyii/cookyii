<?php
/**
 * BlankQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace resources\queries;

/**
 * Class BlankQuery
 * @package resources\queries
 */
class BlankQuery extends \yii\db\ActiveQuery
{

    /**
     * @param mixed $id
     * @return self
     */
    public function byId($id)
    {
        $this->andWhere(['id' => $id]);

        return $this;
    }
}