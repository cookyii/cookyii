<?php
/**
 * ItemSectionQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\resources\Feed\queries;

/**
 * Class ItemSectionQuery
 * @package cookyii\modules\Feed\resources\Feed\queries
 */
class ItemSectionQuery extends \yii\db\ActiveQuery
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