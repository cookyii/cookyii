<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Page\resources\Page;

use cookyii\db\traits\ActivationTrait;
use cookyii\db\traits\SoftDeleteTrait;
use yii\helpers\Json;

/**
 * Class Model
 * @package cookyii\modules\Page\resources\Page
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $content
 * @property string $meta
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_at
 * @property integer $activated_at
 */
class Model extends \cookyii\db\ActiveRecord
{

    use Serialize,
        ActivationTrait,
        SoftDeleteTrait;

    static $tableName = '{{%page}}';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['blameable'] = \cookyii\behaviors\BlameableBehavior::class;
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
            [['slug', 'title', 'content', 'meta'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'activated_at', 'deleted_at'], 'integer'],

            /** semantic validators */
            [['slug'], 'unique', 'filter' => $this->isNewRecord ? null : ['not', ['id' => $this->id]]],
            [['slug', 'title'], 'required'],
            [['slug', 'title'], 'filter', 'filter' => 'str_clean'],

            /** default values */
        ];
    }

    /**
     * @param mixed $defaultValues
     * @return mixed
     */
    public function meta($defaultValues = [])
    {
        return empty($this->meta) || $this->meta === '[]'
            ? $defaultValues
            : Json::decode($this->meta);
    }

    /**
     * @return Query
     */
    public static function find()
    {
        return \Yii::createObject(Query::class, [get_called_class()]);
    }
}
