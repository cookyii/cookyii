<?php
/**
 * Serialize.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\resources\FeedSection;

use cookyii\helpers\ApiAttribute;

/**
 * Trait Serialize
 * @package cookyii\modules\Feed\resources\FeedSection
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

        ApiAttribute::datetimeFormat($fields, 'created_at');
        ApiAttribute::datetimeFormat($fields, 'updated_at');
        ApiAttribute::datetimeFormat($fields, 'published_at');
        ApiAttribute::datetimeFormat($fields, 'archived_at');
        ApiAttribute::datetimeFormat($fields, 'deleted_at');
        ApiAttribute::datetimeFormat($fields, 'activated_at');

        return $fields;
    }
}
