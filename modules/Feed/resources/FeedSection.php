<?php
/**
 * FeedSection.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\resources;

use cookyii\helpers\ApiAttribute;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class FeedSection
 * @package cookyii\modules\Feed\resources
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
 * @property \cookyii\modules\Feed\resources\FeedSection[] $parents
 * @property \cookyii\modules\Feed\resources\FeedSection[] $children
 * @property \cookyii\modules\Feed\resources\FeedItemSection[] $sectionItems
 * @property \cookyii\modules\Feed\resources\FeedItem[] $items
 */
class FeedSection extends \cookyii\db\ActiveRecord
{

    use \cookyii\db\traits\ActivationTrait,
        \cookyii\db\traits\SoftDeleteTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \cookyii\behaviors\BlameableBehavior::className(),
            \cookyii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        unset(
            $fields['meta'],
            $fields['created_by'], $fields['updated_by'],
            $fields['created_at'], $fields['updated_at'],
            $fields['published_at'], $fields['archived_at'],
            $fields['deleted_at'], $fields['activated_at']
        );

        $fields['published'] = [$this, 'isPublished'];
        $fields['archived'] = [$this, 'isArchived'];
        $fields['deleted'] = [$this, 'isDeleted'];
        $fields['activated'] = [$this, 'isActivated'];

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        $fields = parent::extraFields();

        $fields['meta'] = function (FeedSection $Model) {
            return $Model->meta();
        };

        ApiAttribute::datetimeFormat($fields, 'created_at');
        ApiAttribute::datetimeFormat($fields, 'updated_at');
        ApiAttribute::datetimeFormat($fields, 'published_at');
        ApiAttribute::datetimeFormat($fields, 'archived_at');
        ApiAttribute::datetimeFormat($fields, 'deleted_at');
        ApiAttribute::datetimeFormat($fields, 'activated_at');

        return $fields;
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

        /** @var FeedSection $SectionModel */
        $SectionModel = \Yii::createObject(FeedSection::className());

        if (empty($Sections) && empty($parent)) {
            /** @var queries\FeedSectionQuery $SectionsQuery */
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
     * @return \cookyii\modules\Feed\resources\queries\FeedSectionQuery
     */
    public function getParents()
    {
        /** @var FeedSection $SectionModel */
        $SectionModel = \Yii::createObject(FeedSection::className());

        return $this->hasMany($SectionModel::className(), ['id' => 'parent_id'])
            ->inverseOf('section');
    }

    /**
     * @return \cookyii\modules\Feed\resources\queries\FeedSectionQuery
     */
    public function getChildren()
    {
        /** @var FeedSection $SectionModel */
        $SectionModel = \Yii::createObject(FeedSection::className());

        return $this->hasMany($SectionModel::className(), ['parent_id' => 'id'])
            ->inverseOf('section');
    }

    /**
     * @return \cookyii\modules\Feed\resources\queries\FeedItemSectionQuery
     */
    public function getSectionItems()
    {
        /** @var FeedItemSection $ItemSectionModel */
        $ItemSectionModel = \Yii::createObject(FeedItemSection::className());

        return $this->hasMany($ItemSectionModel::className(), ['section_id' => 'id'])
            ->inverseOf('section');
    }

    /**
     * @return \cookyii\modules\Feed\resources\queries\FeedItemQuery
     */
    public function getItems()
    {
        /** @var FeedItem $ItemModel */
        $ItemModel = \Yii::createObject(FeedItem::className());

        return $this->hasMany($ItemModel::className(), ['id' => 'item_id'])
            ->via('sectionItems');
    }

    /**
     * @return \cookyii\modules\Feed\resources\queries\FeedSectionQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Feed\resources\queries\FeedSectionQuery::className(),
            [get_called_class()]
        );
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%feed_section}}';
    }
}
