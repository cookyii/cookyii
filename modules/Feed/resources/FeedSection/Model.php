<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\resources\FeedSection;

use cookyii\helpers\ApiAttribute;
use cookyii\modules\Feed\resources\FeedItem\Model as FeedItemModel;
use cookyii\modules\Feed\resources\FeedItemSection\Model as FeedItemSectionModel;
use cookyii\modules\Feed\resources\FeedSection\Model as FeedSectionModel;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class Model
 * @package cookyii\modules\Feed\resources\FeedSection
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $slug
 * @property string $title
 * @property string $meta
 * @property integer $sort
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published_at
 * @property integer $archived_at
 * @property integer $deleted_at
 * @property integer $activated_at
 *
 * @property FeedSectionModel[] $parents
 * @property FeedSectionModel[] $children
 * @property FeedItemSectionModel[] $sectionItems
 * @property FeedItemModel[] $items
 */
class Model extends \cookyii\db\ActiveRecord
{

    use \cookyii\db\traits\ActivationTrait,
        \cookyii\db\traits\SoftDeleteTrait;

    static $tableName = '{{%feed_section}}';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'blameable' => \cookyii\behaviors\BlameableBehavior::className(),
            'timestamp' => \cookyii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['slug', 'title', 'meta'], 'string'],
            [
                [
                    'parent_id', 'sort', 'created_by', 'updated_by',
                    'created_at', 'updated_at', 'published_at', 'archived_at', 'activated_at', 'deleted_at',
                ], 'integer',
            ],

            /** semantic validators */
            [['slug', 'title'], 'required'],
            [['slug'], 'unique', 'filter' => $this->isNewRecord ? null : ['not', ['id' => $this->id]]],
            [['slug', 'title', 'meta'], 'filter', 'filter' => 'str_clean'],

            /** default values */
        ];
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return empty($this->published_at) || ($this->published_at <= time() && !$this->isArchived());
    }

    /**
     * @return bool
     */
    public function isArchived()
    {
        return !empty($this->archived_at) && $this->archived_at <= time();
    }

    /**
     * @param mixed $defaultValues
     * @return mixed
     */
    public function meta($defaultValues = [])
    {
        return empty($this->meta) || $this->meta === '[]'
            ? $defaultValues
            : Json::decode($this->meta);
    }

    /**
     * @param bool $with_deleted
     * @param static[]|null $Sections
     * @param integer|null $parent
     * @return array
     */
    public static function getTree($with_deleted = false, $Sections = null, $parent = null)
    {
        $result = [
            'sections' => [],
            'contain' => [],
            'models' => [],
        ];

        /** @var FeedSectionModel $SectionModel */
        $SectionModel = \Yii::createObject(FeedSectionModel::className());

        if (empty($Sections) && empty($parent)) {
            /** @var \cookyii\modules\Feed\resources\FeedSection\Query $SectionsQuery */
            $SectionsQuery = $SectionModel::find();

            if ($with_deleted === false) {
                $SectionsQuery->withoutDeleted();
            }

            /** @var static[] $Sections */
            $Sections = $SectionsQuery
                ->orderBy(['id' => SORT_ASC])
                ->all();
        }

        if (!empty($Sections)) {
            foreach ($Sections as $Section) {
                if ($Section->parent_id === $parent) {
                    $work = static::getTree($with_deleted, $Sections, $Section->id);

                    array_push($work['contain'], $Section->slug);

                    $result['contain'] = array_merge($result['contain'], $work['contain']);

                    $result['sections'][$Section->id] = [
                        'id' => $Section->id,
                        'title' => $Section->title,
                        'slug' => $Section->slug,
                        'sort' => $Section->sort,
                        'contain' => $work['contain'],
                        'sections' => $work['sections'],
                    ];
                }
            }
        }

        usort($result['sections'], function ($a, $b) {
            if ($a['sort'] == $b['sort']) {
                return 0;
            }

            return ($a['sort'] < $b['sort']) ? -1 : 1;
        });

        $all_sections = static::find()
            ->orderBy(['id' => SORT_ASC])
            ->asArray()
            ->all();

        $result['models'] = ArrayHelper::index($all_sections, 'slug');

        unset($Sections);

        return $result;
    }

    /**
     * @return \cookyii\modules\Feed\resources\FeedSection\Query
     */
    public function getParents()
    {
        /** @var FeedSectionModel $FeedSectionModel */
        $FeedSectionModel = \Yii::createObject(FeedSectionModel::className());

        /** @var \cookyii\modules\Feed\resources\FeedSection\Query $Query */
        $Query = $this->hasMany($FeedSectionModel::className(), ['id' => 'parent_id']);

        return $Query
            ->inverseOf('section');
    }

    /**
     * @return \cookyii\modules\Feed\resources\FeedSection\Query
     */
    public function getChildren()
    {
        /** @var FeedSectionModel $FeedSectionModel */
        $FeedSectionModel = \Yii::createObject(FeedSectionModel::className());

        /** @var \cookyii\modules\Feed\resources\FeedSection\Query $Query */
        $Query = $this->hasMany($FeedSectionModel::className(), ['parent_id' => 'id']);

        return $Query
            ->inverseOf('section');
    }

    /**
     * @return \cookyii\modules\Feed\resources\FeedItemSection\Query
     */
    public function getSectionItems()
    {
        /** @var FeedItemSectionModel $FeedItemSectionModel */
        $FeedItemSectionModel = \Yii::createObject(FeedItemSectionModel::className());

        /** @var \cookyii\modules\Feed\resources\FeedItemSection\Query $Query */
        $Query = $this->hasMany($FeedItemSectionModel::className(), ['section_id' => 'id']);

        return $Query
            ->inverseOf('section');
    }

    /**
     * @return \cookyii\modules\Feed\resources\FeedItem\Query
     */
    public function getItems()
    {
        /** @var FeedItemModel $FeedItemModel */
        $FeedItemModel = \Yii::createObject(FeedItemModel::className());

        /** @var \cookyii\modules\Feed\resources\FeedItem\Query $Query */
        $Query = $this->hasMany($FeedItemModel::className(), ['id' => 'item_id']);

        return $Query
            ->via('sectionItems');
    }

    /**
     * @return Query
     */
    public static function find()
    {
        return \Yii::createObject(Query::class, [get_called_class()]);
    }
}
