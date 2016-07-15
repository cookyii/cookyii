<?php
/**
 * Query.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Media\resources\Media;

/**
 * Class Query
 * @package cookyii\modules\Media\resources\Media
 *
 * @method Model|array|null one($db = null)
 * @method Model[]|array all($db = null)
 */
class Query extends \yii\db\ActiveQuery
{

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
     * @param string|array $hash
     * @return static
     */
    public function bySha1($hash)
    {
        $this->andWhere(['sha1' => $hash]);

        return $this;
    }
}
