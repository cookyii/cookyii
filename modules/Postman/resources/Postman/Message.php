<?php
/**
 * Message.php
 * @author Revin Roman http://phptime.ru
 */

namespace resources\Postman;

use yii\helpers\Html;
use yii\helpers\Json;

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
 * @property string $code
 * @property integer $created_at
 * @property integer $sent_at
 * @property integer $deleted_at
 */
class Message extends \yii\db\ActiveRecord
{

    use \cookyii\db\traits\SoftDeleteTrait;

    const FROM_NAME = 'Postman';

    const LAYOUT_CODE = '.layout';

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
            [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    static::EVENT_BEFORE_INSERT => 'code',
                ],
                'value' => function ($event) {
                    return Security()->generateRandomString(32);
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        $fields['deleted'] = 'deleted';

        unset($fields['code']);

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['subject', 'content_text', 'content_html', 'address', 'code'], 'string'],
            [['status', 'created_at', 'sent_at', 'deleted_at'], 'integer'],

            /** semantic validators */
            [['subject'], 'required'],
            [['subject', 'content_text'], 'filter', 'filter' => 'str_clean'],
            [['status'], 'in', 'range' => array_keys(static::getAllStatuses())],

            /** default values */
            [['status'], 'default', 'value' => static::STATUS_NEW],
        ];
    }

    /**
     * @param integer $type
     * @param string $email
     * @param string|null $name
     * @return static
     */
    protected function addAddress($type, $email, $name = null)
    {
        $address = empty($this->address) ? [] : Json::decode($this->address);

        $address[] = [
            'type' => $type,
            'email' => $email,
            'name' => $name,
        ];

        $this->address = Json::encode($address);

        return $this;
    }

    /**
     * @param string $email
     * @param string|null $name
     * @return static
     */
    public function addTo($email, $name = null)
    {
        return $this->addAddress(static::ADDRESS_TYPE_TO, $email, $name);
    }

    /**
     * @param string $email
     * @param string|null $name
     * @return static
     */
    public function addCc($email, $name = null)
    {
        return $this->addAddress(static::ADDRESS_TYPE_CC, $email, $name);
    }

    /**
     * @param string $email
     * @param string|null $name
     * @return static
     */
    public function addBcc($email, $name = null)
    {
        return $this->addAddress(static::ADDRESS_TYPE_BCC, $email, $name);
    }

    /**
     * @param bool $save
     * @return bool
     */
    public function send($save = true)
    {
        $result = false;

        $errors = false;

        if ($save) {
            $this->validate() && $this->save();

            $errors = $this->hasErrors();
        }

        if (!$errors) {
            $address = empty($this->address) ? [] : Json::decode($this->address);

            $reply_to = [];
            $to = [];
            $cc = [];
            $bcc = [];

            if (!empty($address)) {
                foreach ($address as $addr) {
                    switch ($addr['type']) {
                        case static::ADDRESS_TYPE_REPLY_TO:
                            $reply_to[$addr['email']] = $addr['name'];
                            break;
                        case static::ADDRESS_TYPE_TO:
                            $to[$addr['email']] = $addr['name'];
                            break;
                        case static::ADDRESS_TYPE_CC:
                            $cc[$addr['email']] = $addr['name'];
                            break;
                        case static::ADDRESS_TYPE_BCC:
                            $bcc[$addr['email']] = $addr['name'];
                            break;
                    }
                }
            }

            $Message = \Yii::$app->mailer->compose()
                ->setCharset('UTF-8')
                ->setFrom([getenv('SMTP_USER') => static::FROM_NAME])
                ->setSubject($this->subject)
                ->setTextBody($this->content_text)
                ->setHtmlBody($this->content_html);

            if (!empty($reply_to)) {
                $Message->setReplyTo($reply_to);
            }

            if (!empty($to)) {
                $Message->setTo($to);
            }

            if (!empty($cc)) {
                $Message->setCc($cc);
            }

            if (!empty($bcc)) {
                $Message->setBcc($bcc);
            }

            $result = $Message->send();

            if ($result === true) {
                $this->sent_at = time();
                $this->update();
            }
        }

        return $result;
    }

    /**
     * @param string $template_code
     * @param string|null $subject
     * @param string $styles
     * @return \resources\Postman\Message
     * @throws \yii\web\ServerErrorHttpException
     */
    public static function create($template_code, $subject = null, $styles = '')
    {
        /** @var Template $Template */
        $Template = Template::find()
            ->byCode($template_code)
            ->one();

        if (empty($Template)) {
            throw new \yii\web\ServerErrorHttpException(sprintf('Message template `%s` not found.', $template_code));
        }

        $subject = empty($subject)
            ? $Template->subject
            : $subject;

        $styles = trim($Template->styles . PHP_EOL . $styles);

        $Message = static::compose($subject, $Template->content_text, $Template->content_html, $styles, $Template->use_layout);

        $Message->address = $Template->address;

        return $Message;
    }

    /**
     * @param string $subject
     * @param string $content_text
     * @param string $content_html
     * @param string $styles
     * @param bool $use_layout
     * @return static
     */
    public static function compose($subject, $content_text, $content_html, $styles = '', $use_layout = true)
    {
        $layout_text = '{content}';
        $layout_html = '{content}';

        if ($use_layout) {
            /** @var Template $LayoutTemplate */
            $LayoutTemplate = Template::find()
                ->byCode(static::LAYOUT_CODE)
                ->one();

            if (!empty($LayoutTemplate)) {
                $layout_text = $LayoutTemplate->content_text;
                $layout_html = $LayoutTemplate->content_html;
                $styles = $LayoutTemplate->styles . PHP_EOL . $styles;
            }
        }

        $styles = trim($styles);

        $Message = new static;
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

        $styles = empty($styles)
            ? null
            : Html::tag('style', $styles, ['type' => 'text/css']);

        if (!empty($styles)) {
            if (preg_match('|<body[^\>]*>|i', $Message->content_html, $m)) {
                $Message->content_html = str_replace($m[0], $m[0] . PHP_EOL . $styles, $Message->content_html);
            } else {
                $Message->content_html = $styles . $Message->content_html;
            }
        }

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

    const ADDRESS_TYPE_REPLY_TO = 1;
    const ADDRESS_TYPE_TO = 2;
    const ADDRESS_TYPE_CC = 3;
    const ADDRESS_TYPE_BCC = 4;

    const STATUS_NEW = 0;
    const STATUS_SENT = 100;
    const STATUS_ERROR = 200;
    const STATUS_CANCELED = 300;
}