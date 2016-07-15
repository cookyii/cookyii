<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\resources\FeedItemSection;

use cookyii\modules\Feed\resources\FeedItem\Model as FeedItemModel;
use cookyii\modules\Feed\resources\FeedSection\Model as FeedSectionModel;

/**
 * Class Model
 * @package cookyii\modules\Feed\resources\FeedItemSection
 *
 * @property integer $item_id
 * @property integer $section_id
 *
 * @property FeedItemModel $item
 * @property FeedSectionModel $sections
 */
class Model extends \cookyii\db\ActiveRecord
{

    static $tableName = '{{%feed_item_section}}';

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
     * @return \cookyii\modules\Feed\resources\FeedItem\Query
     */
    public function getItem()
    {
        /** @var FeedItemModel $FeedItemModel */
        $FeedItemModel = \Yii::createObject(FeedItemModel::className());

        /** @var \cookyii\modules\Feed\resources\FeedItem\Query $Query */
        $Query = $this->hasOne($FeedItemModel::className(), ['id' => 'item_id']);

        return $Query
            ->inverseOf('itemSections');
    }

    /**
     * @return \cookyii\modules\Feed\resources\FeedSection\Query
     */
    public function getSection()
    {
        /** @var FeedSectionModel $FeedSectionModel */
        $FeedSectionModel = \Yii::createObject(FeedSectionModel::className());

        /** @var \cookyii\modules\Feed\resources\FeedSection\Query $Query */
        $Query = $this->hasOne($FeedSectionModel::className(), ['id' => 'section_id']);

        return $Query
            ->inverseOf('sectionItems');
    }

    /**
     * @return Query
     */
    public static function find()
    {
        return \Yii::createObject(Query::class, [get_called_class()]);
    }
}
