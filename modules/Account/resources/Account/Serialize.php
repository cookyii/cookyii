<?php
/**
 * Serialize.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\Account;

use cookyii\helpers\ApiAttribute;
use cookyii\modules\Account\resources\AccountAlert\Model as AccountAlertModel;
use yii\helpers\ArrayHelper;

/**
 * Trait Serialize
 * @package cookyii\modules\Account\resources\Account
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
            $fields['password_hash'], $fields['token'], $fields['auth_key'],
            $fields['created_at'], $fields['updated_at'], $fields['activated_at'], $fields['deleted_at']
        );

        $fields['avatar'] = function (Model $Model) {
            return $Model->presentHelper->avatar;
        };

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

        $fields['roles'] = function (Model $Model) {
            $result = [];

            $roles = AuthManager()->getRolesByUser($Model->id);

            foreach ($roles as $role => $conf) {
                $result[$role] = true;
            }

            return $result;
        };

        $fields['permissions'] = function (Model $Model) {
            $result = [];

            $permissions = AuthManager()->getPermissionsByUser($Model->id);

            foreach ($permissions as $permission => $conf) {
                $result[$permission] = true;
            }

            return $result;
        };

        $fields['properties'] = function (Model $Model) {
            return $Model->properties();
        };

        $fields['alerts'] = function (Model $Model) {
            $Alerts = $this->alerts;

            return empty($Alerts) ? [] : ArrayHelper::getColumn($Alerts, function (AccountAlertModel $Model) {
                return $Model->toArray();
            });
        };

        ApiAttribute::datetimeFormat($fields, 'created_at');
        ApiAttribute::datetimeFormat($fields, 'updated_at');
        ApiAttribute::datetimeFormat($fields, 'activated_at');
        ApiAttribute::datetimeFormat($fields, 'deleted_at');

        return $fields;
    }
}
