<?php
/**
 * PageQuery.php
 * @author Revin Roman http://phptime.ru
 */

namespace resources\queries;

/**
 * Class PageQuery
 * @package resources\queries
 */
class PageQuery extends \yii\db\ActiveQuery
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

    /**
     * @param mixed $slug
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
    public function onlyDeleted()
    {
        $this->andWhere(['deleted' => \resources\Page::DELETED]);

        return $this;
    }

    /**
     * @return self
     */
    public function withoutDeleted()
    {
        $this->andWhere(['deleted' => \resources\Page::NOT_DELETED]);

        return $this;
    }

    /**
     * @return self
     */
    public function withoutDeactivated()
    {
        $this->andWhere(['activated' => \resources\Page::ACTIVATED]);

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
            array_merge(['or'], array_map(function ($value) { return ['like', 'content', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'meta', $value]; }, $words)),
        ]);

        return $this;
    }
}