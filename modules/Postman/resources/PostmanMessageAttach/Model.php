<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman\resources\PostmanMessageAttach;

use cookyii\modules\Media\resources\Media\Model as MediaModel;
use cookyii\modules\Postman\resources\PostmanMessage\Model as PostmanMessageModel;

/**
 * Class Model
 * @package cookyii\modules\Postman\resources\PostmanMessageAttach
 *
 * @property integer $message_id
 * @property integer $media_id
 * @property string $embed
 *
 * @property MediaModel $media
 * @property PostmanMessageModel $message
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
            [['message_id', 'media_id'], 'integer'],
            [['embed'], 'string'],

            /** semantic validators */
            [['message_id', 'media_id'], 'required'],
        ];
    }

    /**
     * @return \cookyii\modules\Postman\resources\PostmanMessage\Query
     */
    public function getMessage()
    {
        return $this->hasOne(PostmanMessageModel::class, ['id' => 'message_id']);
    }

    /**
     * @return \cookyii\modules\Media\resources\Media\Query
     */
    public function getMedia()
    {
        return $this->hasOne(MediaModel::class, ['id' => 'media_id']);
    }

    /**
     * @return Query
     */
    public static function find()
    {
        return \Yii::createObject(Query::class, [get_called_class()]);
    }
}
