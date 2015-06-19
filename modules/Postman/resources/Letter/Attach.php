<?php
/**
 * Attach.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace resources\Letter;

/**
 * Class Attach
 * @package resources\Letter
 *
 * @property integer $letter_id
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
            [['letter_id', 'media_id'], 'integer'],
            [['type'], 'boolean'],

            /** semantic validators */
            [['letter_id', 'media_id'], 'required'],

            /** default values */
            [['embed'], 'default', 'value' => static::EMBED_NO],
        ];
    }

    /**
     * @return \resources\Letter\queries\LetterAttachQuery
     */
    public static function find()
    {
        return new \resources\Letter\queries\LetterAttachQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%postman_letter_attach}}';
    }

    const EMBED_NO = 0;
    const EMBED_YES = 1;
}