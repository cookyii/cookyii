<?php
/**
 * Query.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\resources\FeedItemSection;

/**
 * Class Query
 * @package cookyii\modules\Feed\resources\FeedItemSection
 *
 * @method Model|array|null one($db = null)
 * @method Model[]|array all($db = null)
 */
class Query extends \yii\db\ActiveQuery
{

    /**
     * @param integer|array $item_id
     * @return static
     */
    public function byItemId($item_id)
    {
        $this->andWhere(['item_id' => $item_id]);

        return $this;
    }

    /**
     * @param integer|array $section_id
     * @return static
     */
    public function bySectionId($section_id)
    {
        $this->andWhere(['section_id' => $section_id]);

        return $this;
    }
}