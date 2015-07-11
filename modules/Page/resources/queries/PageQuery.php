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

    use \components\db\traits\query\ActivatedQueryTrait,
        \components\db\traits\query\DeletedQueryTrait;

    /**
     * @param mixed $id
     * @return static
     */
    public function byId($id)
    {
        $this->andWhere(['id' => $id]);

        return $this;
    }

    /**
     * @param mixed $slug
     * @return static
     */
    public function bySlug($slug)
    {
        $this->andWhere(['slug' => $slug]);

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
            array_merge(['or'], array_map(function ($value) { return ['like', 'content', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'meta', $value]; }, $words)),
        ]);

        return $this;
    }
}