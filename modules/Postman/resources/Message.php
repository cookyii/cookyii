<?php
/**
 * Message.php
 * @author Revin Roman http://phptime.ru
 */

namespace resources\Postman;

/**
 * Class Message
 * @package resources\Postman
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
class Message extends \yii\db\ActiveRecord
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
     * @param string $subject
     * @param string $content_text
     * @param string $content_html
     * @param bool $use_layout
     * @return self
     */
    public static function compose($subject, $content_text, $content_html, $use_layout = true)
    {
        $layout_text = '{content}';
        $layout_html = '{content}';

        if ($use_layout) {
            /** @var Template $LayoutTemplate */
            $LayoutTemplate = Template::find()
                ->byCode('.layout')
                ->one();

            if (!empty($LayoutTemplate)) {
                $layout_text = $LayoutTemplate->content_text;
                $layout_html = $LayoutTemplate->content_html;
            }
        }

        $Message = new self;
        $Message->subject = $subject;

        $replace_text = [
            '{subject}' => $subject,
            '{content}' => $content_text,
        ];

        $Message->content_text = str_replace(
            array_keys($replace_text),
            array_values($replace_text),
            $layout_text
        );

        $replace_html = [
            '{subject}' => $subject,
            '{content}' => $content_html,
        ];

        $Message->content_html = str_replace(
            array_keys($replace_html),
            array_values($replace_html),
            $layout_html
        );

        return $Message;
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
     * @return \resources\Postman\queries\MessageQuery
     */
    public static function find()
    {
        return new \resources\Postman\queries\MessageQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%postman_message}}';
    }

    const STATUS_NEW = 0;
    const STATUS_SENT = 100;
    const STATUS_ERROR = 200;
    const STATUS_CANCELED = 300;
}