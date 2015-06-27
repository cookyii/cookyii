<?php
/**
 * Item.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace resources\Feed;

use yii\helpers\Json;

/**
 * Class Item
 * @package resources\Feed
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
 * @property integer $activated
 * @property integer $deleted
 *
 * @property ItemSection[] $itemSections
 * @property Section[] $sections
 */
class Item extends \yii\db\ActiveRecord
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
            [['slug', 'title', 'content_preview', 'content_detail', 'meta'], 'string'],
            [['picture_media_id', 'sort', 'created_by', 'updated_by', 'created_at', 'updated_at', 'published_at', 'archived_at'], 'integer'],
            [['activated', 'deleted'], 'boolean'],

            /** semantic validators */
            [['slug', 'title'], 'required'],
            [['slug'], 'unique', 'filter' => $this->isNewRecord ? null : ['not', ['id' => $this->id]]],
            [['slug', 'title', 'meta'], 'filter', 'filter' => 'str_clean'],
            [['content_preview', 'content_detail'], 'filter', 'filter' => 'str_pretty'],

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
     * @return \resources\Feed\queries\ItemSectionQuery
     */
    public function getItemSections()
    {
        return $this->hasMany(ItemSection::className(), ['item_id' => 'id']);
    }

    /**
     * @return \resources\Feed\queries\SectionQuery
     */
    public function getSections()
    {
        return $this->hasMany(Section::className(), ['id' => 'section_id'])
            ->via('itemSections');
    }

    /**
     * @return \resources\Feed\queries\ItemQuery
     */
    public static function find()
    {
        return new \resources\Feed\queries\ItemQuery(get_called_class());
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%feed_item}}';
    }

    const NOT_ACTIVATED = 0;
    const ACTIVATED = 1;

    const NOT_DELETED = 0;
    const DELETED = 1;
}