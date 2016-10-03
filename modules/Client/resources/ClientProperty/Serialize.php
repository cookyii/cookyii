<?php
/**
 * Serialize.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\resources\ClientProperty;

use cookyii\helpers\ApiAttribute;

/**
 * Trait Serialize
 * @package cookyii\modules\Client\resources\ClientProperty
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
            $fields['client_id'],
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
