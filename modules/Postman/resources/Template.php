<?php
/**
 * Template.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace resources\Postman;

/**
 * Class Template
 * @package resources\Postman
 *
 * @property integer $id
 * @property string $code
 * @property string $subject
 * @property string $content_text
 * @property string $content_html
 * @property string $address
 * @property string $params
 * @property string $description
 * @property integer $use_layout
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted
 */
class Template extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['code', 'subject', 'content_text', 'content_html', 'address', 'params', 'description'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['use_layout', 'deleted'], 'boolean'],

            /** semantic validators */
            [['code', 'subject'], 'required'],
            [['code', 'subject', 'content_text', 'address', 'params', 'description'], 'filter', 'filter' => 'str_clean'],
            [['content_html'], 'filter', 'filter' => 'trim'],

            /** default values */
            [['use_layout'], 'default', 'value' => static::USE_LAYOUT],
            [['deleted'], 'default', 'value' => static::NOT_DELETED],
        ];
    }

    /**
     * @return \resources\Postman\queries\TemplateQuery
     */
    public static function find()
    {
        return new \resources\Postman\queries\TemplateQuery(get_called_class());
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

    const NOT_DELETED = 0;
    const DELETED = 1;
}