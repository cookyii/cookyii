<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources\AccountAlert;

use cookyii\helpers\ApiAttribute;
use cookyii\modules\Account\resources\Account\Model as AccountModel;

/**
 * Class Model
 * @package cookyii\modules\Account\resources\AccountAlert
 *
 * @property string $id
 * @property integer $account_id
 * @property integer $type
 * @property string $message
 * @property string $detail
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_at
 *
 * @property AccountModel $account
 */
class Model extends \cookyii\db\ActiveRecord
{

    use \cookyii\db\traits\SoftDeleteTrait;

    static $tableName = '{{%account_alert}}';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'unique-code-id' => \cookyii\behaviors\UniqueCodeIdBehavior::class,
            'timestamp' => \cookyii\behaviors\TimestampBehavior::class,
        ];
    }

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

        $fields['class'] = function (self $Model) {
            switch ($Model->type) {
                default:
                    $result = null;
                    break;
                case static::TYPE_DANGER:
                    $result = 'alert-danger';
                    break;
                case static::TYPE_WARNING:
                    $result = 'alert-warning';
                    break;
                case static::TYPE_INFO:
                    $result = 'alert-info';
                    break;
                case static::TYPE_SUCCESS:
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['message', 'detail'], 'string'],
            [['account_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],

            /** semantic validators */
            [['account_id', 'type', 'message'], 'required'],
            [['type'], 'in', 'range' => array_keys(static::getAllTypes())],

            /** default values */
            [['type'], 'default', 'value' => static::TYPE_INFO],
        ];
    }

    /**
     * @param integer $account_id
     * @param integer $type
     * @param string $message
     * @param string|null $detail
     * @param integer|null $threshold
     * @return bool|null|Model
     */
    public static function push($account_id, $type, $message, $detail = null, $threshold = null)
    {
        $Alert = false;

        if (!empty($threshold)) {
            $Alert = static::find()
                ->byMessage($message)
                ->createdAfter(strtotime($threshold))
                ->one();
        }

        if (empty($Alert)) {
            $Alert = static::find()
                ->byMessage($message)
                ->withoutDeleted()
                ->one();
        }

        if (empty($Alert)) {
            $Alert = new static;
            $Alert->setAttributes([
                'account_id' => $account_id,
                'type' => $type,
                'message' => $message,
                'detail' => $detail,
            ]);

            $Alert->validate() && $Alert->save(false);
        }

        return $Alert;
    }

    /**
     * @return \cookyii\modules\Account\resources\Account\Query
     */
    public function getAccount()
    {
        return $this->hasOne(AccountModel::class, ['id' => 'account_id']);
    }

    /**
     * @return array
     */
    public static function getAllTypes()
    {
        return [
            static::TYPE_DANGER => 'danger',
            static::TYPE_WARNING => 'warning',
            static::TYPE_INFO => 'info',
            static::TYPE_SUCCESS => 'success',
        ];
    }

    /**
     * @return Query
     */
    public static function find()
    {
        return \Yii::createObject(Query::class, [get_called_class()]);
    }

    const TYPE_DANGER = 100;
    const TYPE_WARNING = 200;
    const TYPE_INFO = 300;
    const TYPE_SUCCESS = 400;
}
