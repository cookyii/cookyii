<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\resources\PostmanMessageAttach;

/**
 * Class Model
 * @package cookyii\modules\Postman\resources\PostmanMessageAttach
 *
 * @property integer $letter_id
 * @property integer $media_id
 * @property integer $embed
 */
class Model extends \cookyii\db\ActiveRecord
{

    static $tableName = '{{%postman_message_attach}}';

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
     * @return Query
     */
    public static function find()
    {
        return \Yii::createObject(Query::class, [get_called_class()]);
    }

    const EMBED_NO = 0;
    const EMBED_YES = 1;
}
