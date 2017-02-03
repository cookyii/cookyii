<?php
/**
 * Serialize.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\AccountAlert;

use cookyii\helpers\ApiAttribute;

/**
 * Trait Serialize
 * @package cookyii\modules\Account\resources\AccountAlert
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

        $fields['class'] = function (Model $Model) {
            switch ($Model->type) {
                default:
                    $result = null;
                    break;
                case Model::TYPE_DANGER:
                    $result = 'alert-danger';
                    break;
                case Model::TYPE_WARNING:
                    $result = 'alert-warning';
                    break;
                case Model::TYPE_INFO:
                    $result = 'alert-info';
                    break;
                case Model::TYPE_SUCCESS:
                    $result = 'alert-success';
                    break;
            }

            return $result;
        };

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
