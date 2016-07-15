<?php
/**
 * Query.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace resources\Blank;

/**
 * Class Query
 * @package resources\Blank
 *
 * @method Model|array|null one($db = null)
 * @method Model[]|array all($db = null)
 */
class Query extends \yii\db\ActiveQuery
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