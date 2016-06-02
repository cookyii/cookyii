<?php
/**
 * FeedItemSection.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\resources;

/**
 * Class FeedItemSection
 * @package cookyii\modules\Feed\resources
 *
 * @property integer $item_id
 * @property integer $section_id
 *
 * @property \cookyii\modules\Feed\resources\FeedItem $item
 * @property \cookyii\modules\Feed\resources\FeedSection $sections
 */
class FeedItemSection extends \cookyii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['item_id', 'section_id'], 'integer'],

            /** semantic validators */
            [['item_id', 'section_id'], 'required'],

            /** default values */
        ];
    }

    /**
     * @return queries\FeedItemQuery
     */
    public function getItem()
    {
        /** @var FeedItem $ItemModel */
        $ItemModel = \Yii::createObject(FeedItem::className());

        return $this->hasOne($ItemModel::className(), ['id' => 'item_id'])
            ->inverseOf('itemSections');
    }

    /**
     * @return queries\FeedSectionQuery
     */
    public function getSection()
    {
        /** @var FeedSection $SectionModel */
        $SectionModel = \Yii::createObject(FeedSection::className());

        return $this->hasOne($SectionModel::className(), ['id' => 'section_id'])
            ->inverseOf('sectionItems');
    }

    /**
     * @return \cookyii\modules\Feed\resources\queries\FeedItemSectionQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Feed\resources\queries\FeedItemSectionQuery::className(),
            [get_called_class()]
        );
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%feed_item_section}}';
    }
}
