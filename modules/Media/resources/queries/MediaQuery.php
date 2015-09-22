<?php
/**
 * MediaQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Media\resources\queries;

/**
 * Class MediaQuery
 * @package cookyii\modules\Media\resources\queries
 *
 * @method \cookyii\modules\Media\resources\Media|array|null one($db = null)
 * @method \cookyii\modules\Media\resources\Media[]|array all($db = null)
 */
class MediaQuery extends \yii\db\ActiveQuery
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