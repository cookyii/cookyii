<?php
/**
 * Section.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\resources\Feed;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class Section
 * @package cookyii\modules\Feed\resources\Feed
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
 */
class Section extends \yii\db\ActiveRecord
{

    use \cookyii\db\traits\ActivationTrait,
        \cookyii\db\traits\SoftDeleteTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\BlameableBehavior::className(),
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        $fields['created_at_format'] = function (Item $Model) {
            return Formatter()->asDatetime($Model->created_at);
        };

        $fields['updated_at_format'] = function (Item $Model) {
            return Formatter()->asDatetime($Model->updated_at);
        };

        $fields['published_at_format'] = function (Item $Model) {
            return Formatter()->asDatetime($Model->published_at);
        };

        $fields['archived_at_format'] = function (Item $Model) {
            return Formatter()->asDatetime($Model->archived_at);
        };

        $fields['deleted_at_format'] = function (Item $Model) {
            return Formatter()->asDatetime($Model->deleted_at);
        };

        $fields['activated_at_format'] = function (Item $Model) {
            return Formatter()->asDatetime($Model->activated_at);
        };

        $fields['published'] = function (Item $Model) {
            return $Model->isPublished();
        };

        $fields['archived'] = function (Item $Model) {
            return $Model->isArchived();
        };

        $fields['deleted'] = function (Item $Model) {
            return $Model->isDeleted();
        };

        $fields['activated'] = function (Item $Model) {
            return $Model->isActivated();
        };

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
                ], 'integer'
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

        if (empty($Sections) && empty($parent)) {
            /** @var \cookyii\modules\Feed\resources\Feed\queries\SectionQuery $SectionsQuery */
            $SectionsQuery = \cookyii\modules\Feed\resources\Feed\Section::find();

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
     * @return \cookyii\modules\Feed\resources\Feed\queries\SectionQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Feed\resources\Feed\queries\SectionQuery::className(), [
                get_called_class(),
            ]
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