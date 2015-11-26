<?php
/**
 * FeedItem.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\resources;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class FeedItem
 * @package cookyii\modules\Feed\resources
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property integer $picture_media_id
 * @property string $content_preview
 * @property string $content_detail
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
 * @property \cookyii\modules\Media\resources\Media $pictureMedia
 * @property FeedItemSection[] $itemSections
 * @property FeedSection[] $sections
 */
class FeedItem extends \yii\db\ActiveRecord
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

        unset($fields['meta']);

        $fields['created_at_format'] = function (FeedItem $Model) {
            return Formatter()->asDatetime($Model->created_at);
        };

        $fields['updated_at_format'] = function (FeedItem $Model) {
            return Formatter()->asDatetime($Model->updated_at);
        };

        $fields['published_at_format'] = function (FeedItem $Model) {
            return Formatter()->asDatetime($Model->published_at);
        };

        $fields['archived_at_format'] = function (FeedItem $Model) {
            return Formatter()->asDatetime($Model->archived_at);
        };

        $fields['deleted_at_format'] = function (FeedItem $Model) {
            return Formatter()->asDatetime($Model->deleted_at);
        };

        $fields['activated_at_format'] = function (FeedItem $Model) {
            return Formatter()->asDatetime($Model->activated_at);
        };

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

        $fields['picture_300'] = function (FeedItem $Model) {
            $result = null;

            $Media = $Model->pictureMedia;
            if (!empty($Media)) {
                $result = $Media->image()->resizeByWidth(300)->export();
            }

            return $result;
        };

        $fields['sections'] = function (FeedItem $Model) {
            $result = [];

            $item_sections = $Model->getItemSections()
                ->asArray()
                ->all();

            if (!empty($item_sections)) {
                $result = ArrayHelper::getColumn($item_sections, 'section_id');
                $result = array_map('intval', $result);
            }

            return $result;
        };

        $fields['meta'] = function (FeedItem $Model) {
            return $Model->meta();
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
            [['slug', 'title', 'content_preview', 'content_detail', 'meta'], 'string'],
            [
                [
                    'picture_media_id', 'sort', 'created_by', 'updated_by',
                    'created_at', 'updated_at', 'published_at', 'archived_at', 'activated_at', 'deleted_at',
                ], 'integer'
            ],

            /** semantic validators */
            [['slug', 'title'], 'required'],
            [['slug'], 'unique', 'filter' => $this->isNewRecord ? null : ['not', ['id' => $this->id]]],
            [['slug', 'title', 'meta'], 'filter', 'filter' => 'str_clean'],
            [['content_preview', 'content_detail'], 'filter', 'filter' => 'str_pretty'],

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
     * @return \cookyii\modules\Media\resources\queries\MediaQuery
     */
    public function getPictureMedia()
    {
        /** @var \cookyii\modules\Media\resources\Media $MediaModel */
        $MediaModel = \Yii::createObject(\cookyii\modules\Media\resources\Media::className());

        return $this->hasOne($MediaModel::className(), ['id' => 'picture_media_id']);
    }

    /**
     * @return \cookyii\modules\Feed\resources\queries\FeedItemSectionQuery
     */
    public function getItemSections()
    {
        /** @var FeedItemSection $ItemSectionModel */
        $ItemSectionModel = \Yii::createObject(FeedItemSection::className());

        return $this->hasMany($ItemSectionModel::className(), ['item_id' => 'id']);
    }

    /**
     * @return \cookyii\modules\Feed\resources\queries\FeedSectionQuery
     */
    public function getSections()
    {
        /** @var Section $SectionModel */
        $SectionModel = \Yii::createObject(Section::className());

        return $this->hasMany($SectionModel::className(), ['id' => 'section_id'])
            ->via('itemSections');
    }

    /**
     * @return \cookyii\modules\Feed\resources\queries\FeedItemQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Feed\resources\queries\FeedItemQuery::className(),
            [get_called_class()]
        );
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%feed_item}}';
    }
}