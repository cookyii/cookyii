<?php
/**
 * Serialize.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Media\resources\Media;

use cookyii\helpers\ApiAttribute;

/**
 * Trait Serialize
 * @package cookyii\modules\Media\resources\Media
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
            $fields['created_by'], $fields['updated_by'],
            $fields['created_at'], $fields['updated_at']
        );

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        $fields = parent::extraFields();

        ApiAttribute::datetimeFormat($fields, 'created_at');
        ApiAttribute::datetimeFormat($fields, 'updated_at');

        return $fields;
    }
}
