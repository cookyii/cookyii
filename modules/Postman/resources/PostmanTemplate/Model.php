<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\resources\PostmanTemplate;

use yii\helpers\Json;

/**
 * Class Model
 * @package cookyii\modules\Postman\resources\PostmanTemplate
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
class Model extends \cookyii\db\ActiveRecord
{

    use Serialize,
        \cookyii\db\traits\SoftDeleteTrait;

    static $tableName = '{{%postman_template}}';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['timestamp'] = \cookyii\behaviors\TimestampBehavior::class;

        return $behaviors;
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
     * @return Query
     */
    public static function find()
    {
        return \Yii::createObject(Query::class, [get_called_class()]);
    }

    const NOT_USE_LAYOUT = 0;
    const USE_LAYOUT = 1;
}
