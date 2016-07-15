<?php
/**
 * Model.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Page\resources\Page;

use cookyii\helpers\ApiAttribute;
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

    use \cookyii\db\traits\ActivationTrait,
        \cookyii\db\traits\SoftDeleteTrait;

    static $tableName = '{{%page}}';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'blameable' => \yii\behaviors\BlameableBehavior::className(),
            'timestamp' => \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        unset(
            $fields['meta'],
            $fields['created_at'], $fields['updated_at'], $fields['activated_at'], $fields['deleted_at']
        );

        $fields['deleted'] = [$this, 'isDeleted'];
        $fields['activated'] = [$this, 'isActivated'];

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        $fields = parent::extraFields();

        $fields['meta'] = function (self $Model) {
            return $Model->meta();
        };

        ApiAttribute::datetimeFormat($fields, 'created_at');
        ApiAttribute::datetimeFormat($fields, 'updated_at');
        ApiAttribute::datetimeFormat($fields, 'activated_at');
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
