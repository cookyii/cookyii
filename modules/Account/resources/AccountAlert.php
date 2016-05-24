<?php
/**
 * AccountAlert.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;


/**
 * Class AccountAlert
 * @package cookyii\modules\Account\resources
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
 * @property \cookyii\modules\Account\resources\Account $account
 */
class AccountAlert extends \yii\db\ActiveRecord
{

    use \cookyii\db\traits\SoftDeleteTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \cookyii\behaviors\UniqueCodeIdBehavior::class,
            \cookyii\behaviors\TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        unset($fields['account_id']);

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
     * @return bool|null|AccountAlert
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
     * @return \cookyii\modules\Account\resources\queries\AccountQuery
     */
    public function getAccount()
    {
        return $this->hasOne(\cookyii\modules\Account\resources\Account::class, ['id' => 'account_id']);
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
     * @return \cookyii\modules\Account\resources\queries\AccountAlertQuery
     */
    public static function find()
    {
        return new \cookyii\modules\Account\resources\queries\AccountAlertQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_alert}}';
    }

    const TYPE_DANGER = 100;
    const TYPE_WARNING = 200;
    const TYPE_INFO = 300;
    const TYPE_SUCCESS = 400;
}