<?php
/**
 * Section.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace resources\Feed;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class Section
 * @package resources\Feed
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
 * @property integer $activated
 * @property integer $deleted
 */
class Section extends \yii\db\ActiveRecord
{

    use \components\db\traits\ActivationTrait;
    use \components\db\traits\SoftDeleteTrait;

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
    public function rules()
    {
        return [
            /** type validators */
            [['slug', 'title', 'meta'], 'string'],
            [['parent_id', 'sort', 'created_by', 'updated_by', 'created_at', 'updated_at', 'published_at', 'archived_at'], 'integer'],
            [['activated', 'deleted'], 'boolean'],

            /** semantic validators */
            [['slug', 'title'], 'required'],
            [['slug'], 'unique', 'filter' => $this->isNewRecord ? null : ['not', ['id' => $this->id]]],
            [['slug', 'title', 'meta'], 'filter', 'filter' => 'str_clean'],

            /** default values */
            [['activated'], 'default', 'value' => static::NOT_ACTIVATED],
            [['deleted'], 'default', 'value' => static::NOT_DELETED],
        ];
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
            /** @var \resources\Feed\queries\SectionQuery $SectionsQuery */
            $SectionsQuery = \resources\Feed\Section::find();

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
     * @return \resources\Feed\queries\SectionQuery
     */
    public static function find()
    {
        return new \resources\Feed\queries\SectionQuery(get_called_class());
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%feed_section}}';
    }

    const NOT_ACTIVATED = 0;
    const ACTIVATED = 1;

    const NOT_DELETED = 0;
    const DELETED = 1;
}