<?php
/**
 * Page.php
 * @author Revin Roman http://phptime.ru
 */

namespace resources;

/**
 * Class Page
 * @package resources
 *
 * @property integer $id
 * @property string $subject
 * @property string $content_text
 * @property string $content_html
 * @property string $address
 * @property integer $status
 * @property integer $created_at
 * @property integer $sent_at
 */
class Letter extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['subject', 'content_text', 'content_html', 'address'], 'string'],
            [['status', 'created_at', 'sent_at'], 'integer'],

            /** semantic validators */
            [['subject'], 'required'],
            [['subject', 'content_text'], 'filter', 'filter' => 'str_clean'],
            [['status'], 'in', 'range' => array_keys(static::getAllStatuses())],

            /** default values */
            [['status'], 'default', 'value' => static::STATUS_NEW],
        ];
    }

    /**
     * @return array
     */
    public static function getAllStatuses()
    {
        return [
            static::STATUS_NEW => \Yii::t('postman', 'New letters'),
            static::STATUS_SENT => \Yii::t('postman', 'Sent letters'),
            static::STATUS_ERROR => \Yii::t('postman', 'Error sent'),
            static::STATUS_CANCELED => \Yii::t('postman', 'Canceled'),
        ];
    }

    /**
     * @return \resources\queries\LetterQuery
     */
    public static function find()
    {
        return new \resources\queries\LetterQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%postman_letter}}';
    }

    const STATUS_NEW = 0;
    const STATUS_SENT = 100;
    const STATUS_ERROR = 200;
    const STATUS_CANCELED = 300;
}