<?php
/**
 * Query.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\resources\FeedSection;

/**
 * Class Query
 * @package cookyii\modules\Feed\resources\FeedSection
 *
 * @method Model|array|null one($db = null)
 * @method Model[]|array all($db = null)
 */
class Query extends \yii\db\ActiveQuery
{

    use \cookyii\db\traits\query\ActivatedQueryTrait,
        \cookyii\db\traits\query\DeletedQueryTrait;

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
     * @param integer|array $parent_id
     * @return static
     */
    public function byParentId($parent_id)
    {
        $this->andWhere(['parent_id' => $parent_id]);

        return $this;
    }

    /**
     * @param string|array $slug
     * @return static
     */
    public function bySlug($slug)
    {
        $this->andWhere(['slug' => $slug]);

        return $this;
    }

    /**
     * @return static
     */
    public function onlyPublished()
    {
        $this->andWhere([
            'or',
            ['published_at' => null],
            ['<=', 'published_at', time()],
        ]);

        return $this;
    }

    /**
     * @return static
     */
    public function onlyNotPublished()
    {
        $this->andWhere([
            'and',
            ['not', ['published_at' => null]],
            ['>=', 'published_at', time()],
        ]);

        return $this;
    }

    /**
     * @return static
     */
    public function onlyArchived()
    {
        $this->andWhere([
            'and',
            ['not', ['archived_at' => null]],
            ['<=', 'archived_at', time()],
        ]);

        return $this;
    }

    /**
     * @return static
     */
    public function onlyNotArchived()
    {
        $this->andWhere([
            'or',
            ['archived_at' => null],
            ['>=', 'archived_at', time()],
        ]);

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
            array_merge(['or'], array_map(function ($value) { return ['like', 'slug', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'title', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'meta', $value]; }, $words)),
        ]);

        return $this;
    }
}
