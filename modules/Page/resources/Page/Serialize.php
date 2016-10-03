<?php
/**
 * Serialize.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Page\resources\Page;

use cookyii\helpers\ApiAttribute;

/**
 * Trait Serialize
 * @package cookyii\modules\Page\resources\Page
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
            $fields['created_at'], $fields['updated_at'], $fields['activated_at'], $fields['deleted_at']
        );

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
        ApiAttribute::datetimeFormat($fields, 'activated_at');
        ApiAttribute::datetimeFormat($fields, 'deleted_at');

        return $fields;
    }
}
