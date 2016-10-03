<?php
/**
 * Serialize.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\resources\FeedItem;

use cookyii\helpers\ApiAttribute;
use yii\helpers\ArrayHelper;

/**
 * Trait Serialize
 * @package cookyii\modules\Feed\resources\FeedItem
 *
 * @mixin Model
 */
trait Serialize
{

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

        $fields['meta'] = function (Model $Model) {
            return $Model->meta();
        };

        $fields['picture_300'] = function (Model $Model) {
            $result = null;

            $Media = $Model->pictureMedia;
            if (!empty($Media)) {
                $result = $Media->image()->resizeByWidth(300)->export();
            }

            return $result;
        };

        $fields['sections'] = function (Model $Model) {
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

        ApiAttribute::datetimeFormat($fields, 'created_at');
        ApiAttribute::datetimeFormat($fields, 'updated_at');
        ApiAttribute::datetimeFormat($fields, 'published_at');
        ApiAttribute::datetimeFormat($fields, 'archived_at');
        ApiAttribute::datetimeFormat($fields, 'deleted_at');
        ApiAttribute::datetimeFormat($fields, 'activated_at');

        return $fields;
    }
}
