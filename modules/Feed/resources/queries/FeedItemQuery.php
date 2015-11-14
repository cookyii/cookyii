<?php
/**
 * FeedItemQuery.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\resources\queries;

use yii\helpers\ArrayHelper;

/**
 * Class FeedItemQuery
 * @package cookyii\modules\Feed\resources\queries
 *
 * @method \cookyii\modules\Feed\resources\FeedItem|array|null one($db = null)
 * @method \cookyii\modules\Feed\resources\FeedItem[]|array all($db = null)
 */
class FeedItemQuery extends \yii\db\ActiveQuery
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
     * @param string|array $slug
     * @return static
     */
    public function bySlug($slug)
    {
        $this->andWhere(['slug' => $slug]);

        return $this;
    }

    /**
     * @param integer|array $section_id
     * @return static
     */
    public function bySectionId($section_id)
    {
        /** @var \cookyii\modules\Feed\resources\FeedItemSection $ItemSectionModel */
        $ItemSectionModel = \Yii::createObject(\cookyii\modules\Feed\resources\FeedItemSection::className());

        /** @var array $item_sections */
        $item_sections = $ItemSectionModel::find()
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
     * @return static
     */
    public function bySectionSlug($section_slug)
    {
        /** @var \cookyii\modules\Feed\resources\FeedSection $SectionModel */
        $SectionModel = \Yii::createObject(\cookyii\modules\Feed\resources\FeedSection::className());

        /** @var array $sections */
        $sections = $SectionModel::find()
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
            array_merge(['or'], array_map(function ($value) { return ['like', 'content_preview', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'content_detail', $value]; }, $words)),
            array_merge(['or'], array_map(function ($value) { return ['like', 'meta', $value]; }, $words)),
        ]);

        return $this;
    }
}