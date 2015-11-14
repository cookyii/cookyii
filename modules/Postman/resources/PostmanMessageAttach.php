<?php
/**
 * PostmanMessageAttach.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\resources;

/**
 * Class PostmanMessageAttach
 * @package cookyii\modules\Postman\resources
 *
 * @property integer $letter_id
 * @property integer $media_id
 * @property integer $embed
 */
class PostmanMessageAttach extends \yii\db\ActiveRecord
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
     * @return \cookyii\modules\Postman\resources\queries\PostmanMessageAttachQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Postman\resources\queries\PostmanMessageAttachQuery::className(), [
                get_called_class(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%postman_message_attach}}';
    }

    const EMBED_NO = 0;
    const EMBED_YES = 1;
}