<?php
/**
 * Serialize.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\resources\PostmanMessage;

use cookyii\helpers\ApiAttribute;

/**
 * Trait Serialize
 * @package cookyii\modules\Postman\resources\PostmanMessage
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
            $fields['code'],
            $fields['created_at'], $fields['scheduled_at'], $fields['sent_at'], $fields['deleted_at']
        );

        $fields['address'] = [$this, 'expandAddress'];

        $fields['sent'] = [$this, 'isSent'];
        $fields['deleted'] = [$this, 'isDeleted'];

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        $fields = parent::extraFields();

        ApiAttribute::datetimeFormat($fields, 'created_at');
        ApiAttribute::datetimeFormat($fields, 'scheduled_at');
        ApiAttribute::datetimeFormat($fields, 'sent_at');
        ApiAttribute::datetimeFormat($fields, 'deleted_at');

        return $fields;
    }
}
