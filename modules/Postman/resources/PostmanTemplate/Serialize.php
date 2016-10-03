<?php
/**
 * Serialize.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\resources\PostmanTemplate;

use cookyii\helpers\ApiAttribute;

/**
 * Trait Serialize
 * @package cookyii\modules\Postman\resources\PostmanTemplate
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
            $fields['created_at'], $fields['updated_at'], $fields['deleted_at']
        );

        $fields['address'] = [$this, 'expandAddress'];
        $fields['params'] = [$this, 'expandParams'];

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
        ApiAttribute::datetimeFormat($fields, 'updated_at');
        ApiAttribute::datetimeFormat($fields, 'deleted_at');

        return $fields;
    }
}
