<?php
/**
 * PostmanTemplate.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\resources;

use cookyii\helpers\ApiAttribute;
use yii\helpers\Json;

/**
 * Class PostmanTemplate
 * @package cookyii\modules\Postman\resources
 *
 * @property integer $id
 * @property string $code
 * @property string $subject
 * @property string $content_text
 * @property string $content_html
 * @property string $styles
 * @property string $address
 * @property string $params
 * @property string $description
 * @property integer $use_layout
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_at
 */
class PostmanTemplate extends \cookyii\db\ActiveRecord
{

    use \cookyii\db\traits\SoftDeleteTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => \cookyii\behaviors\TimestampBehavior::className(),
        ];
    }

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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['code', 'subject', 'content_text', 'content_html', 'styles', 'address', 'params', 'description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['use_layout'], 'boolean'],

            /** semantic validators */
            [['code', 'subject'], 'required'],
            [['code'], 'unique', 'filter' => $this->isNewRecord ? null : ['not', ['id' => $this->id]]],
            [['code', 'subject', 'styles', 'address', 'params', 'description'], 'filter', 'filter' => 'str_clean'],
            [['content_text', 'content_html'], 'filter', 'filter' => 'trim'],

            /** default values */
            [['use_layout'], 'default', 'value' => static::USE_LAYOUT],
        ];
    }

    /**
     * @return array
     */
    public function expandAddress()
    {
        return Json::decode($this->address);
    }

    /**
     * @return array
     */
    public function expandParams()
    {
        return Json::decode($this->params);
    }

    /**
     * @return \cookyii\modules\Postman\resources\queries\PostmanTemplateQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Postman\resources\queries\PostmanTemplateQuery::className(),
            [get_called_class()]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%postman_template}}';
    }

    const NOT_USE_LAYOUT = 0;
    const USE_LAYOUT = 1;
}
