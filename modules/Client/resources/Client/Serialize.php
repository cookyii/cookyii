<?php
/**
 * Serialize.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\resources\Client;

use cookyii\helpers\ApiAttribute;

/**
 * Trait Serialize
 * @package cookyii\modules\Client\resources\Client
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
            $fields['account_id'],
            $fields['created_at'], $fields['updated_at'], $fields['deleted_at']
        );

        $fields['deleted'] = [$this, 'isDeleted'];

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        $fields = parent::extraFields();

        $fields['account'] = function (Model $Model) {
            $result = null;

            $Account = $Model->account;
            if (!empty($Account)) {
                $result = $Account->toArray();
            }

            return $result;
        };

        $fields['properties'] = function (Model $Model) {
            $result = [];

            $properties = $Model->properties();

            if (!empty($properties)) {
                foreach ($properties as $key => $values) {
                    $result[$key] = $values;
                }
            }

            return $result;
        };

        ApiAttribute::datetimeFormat($fields, 'created_at');
        ApiAttribute::datetimeFormat($fields, 'updated_at');
        ApiAttribute::datetimeFormat($fields, 'deleted_at');

        return $fields;
    }
}
