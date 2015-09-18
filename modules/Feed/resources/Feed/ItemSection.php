<?php
/**
 * ItemSection.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\resources\Feed;

/**
 * Class ItemSection
 * @package cookyii\modules\Feed\resources\Feed
 *
 * @property integer $item_id
 * @property integer $section_id
 */
class ItemSection extends \yii\db\ActiveRecord
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
     * @return \cookyii\modules\Feed\resources\Feed\queries\ItemSectionQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Feed\resources\Feed\queries\ItemSectionQuery::className(), [
                get_called_class(),
            ]
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