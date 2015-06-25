<?php
/**
 * ItemQuery.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace resources\Feed\queries;

use yii\helpers\ArrayHelper;

/**
 * Class ItemQuery
 * @package resources\Feed\queries
 */
class ItemQuery extends \yii\db\ActiveQuery
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
     * @param string|array $slug
     * @return self
     */
    public function bySlug($slug)
    {
        $this->andWhere(['slug' => $slug]);

        return $this;
    }

    /**
     * @param integer|array $section_id
     * @return self
     */
    public function bySectionId($section_id)
    {
        /** @var array $item_sections */
        $item_sections = \resources\Feed\ItemSection::find()
            ->bySectionId($section_id)
            ->asArray()
            ->all();

        if (empty($item_sections)) {
            $this->andWhere('1=0');
        } else {
            $this->byId(ArrayHelper::getColumn($item_sections, ['item_id']));
        }

        return $this;
    }

    /**
     * @param string|array $section_slug
     * @return self
     */
    public function bySectionSlug($section_slug)
    {
        /** @var array $sections */
        $sections = \resources\Feed\Section::find()
            ->bySlug($section_slug)
            ->asArray()
            ->all();

        if (empty($sections)) {
            $this->andWhere('1=0');
        } else {
            $this->bySectionId(ArrayHelper::getColumn($sections, ['id']));
        }

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
            array_merge(['or'], array_map(function ($value) { return ['like', 'content_preview', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'content_detail', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'meta', $value]; }, $words)),
        ]);

        return $this;
    }
}