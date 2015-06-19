<?php
/**
 * Attach.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace resources\Letter\Template;

/**
 * Class Attach
 * @package resources\Letter\Template
 *
 * @property integer $letter_template_id
 * @property integer $media_id
 * @property integer $embed
 */
class Attach extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['letter_template_id', 'media_id'], 'integer'],
            [['type'], 'boolean'],

            /** semantic validators */
            [['letter_template_id', 'media_id'], 'required'],

            /** default values */
            [['embed'], 'default', 'value' => static::EMBED_NO],
        ];
    }

    /**
     * @return \resources\Letter\Template\queries\LetterTemplateAttachQuery
     */
    public static function find()
    {
        return new \resources\Letter\Template\queries\LetterTemplateAttachQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%postman_letter_template_attach}}';
    }

    const EMBED_NO = 0;
    const EMBED_YES = 1;
}