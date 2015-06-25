<?php
/**
 * SectionQuery.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace resources\Feed\queries;

/**
 * Class SectionQuery
 * @package resources\Feed\queries
 */
class SectionQuery extends \yii\db\ActiveQuery
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

    /**
     * @param integer|array $parent_id
     * @return self
     */
    public function byParentId($parent_id)
    {
        $this->andWhere(['parent_id' => $parent_id]);

        return $this;
    }

    /**
     * @param string|array $slug
     * @return self
     */
    public function bySlug($slug)
    {
        $this->andWhere(['slug' => $slug]);

        return $this;
    }

    /**
     * @return self
     */
    public function onlyPublished()
    {
        $this
            ->onlyActivated()
            ->withoutDeleted()
            ->andWhere(['<=', 'published_at', time()])
            ->andWhere(['or', ['>=', 'archived_at', time()], ['archived_at' => null]]);

        return $this;
    }

    /**
     * @return self
     */
    public function onlyActivated()
    {
        $this->andWhere(['activated' => \resources\Feed\Section::ACTIVATED]);

        return $this;
    }

    /**
     * @return self
     */
    public function onlyDeactivated()
    {
        $this->andWhere(['activated' => \resources\Feed\Section::NOT_ACTIVATED]);

        return $this;
    }

    /**
     * @return self
     */
    public function withoutDeleted()
    {
        $this->andWhere(['deleted' => \resources\Feed\Section::NOT_DELETED]);

        return $this;
    }

    /**
     * @param string $query
     * @return self
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