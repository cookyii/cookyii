<?php
/**
 * Page.php
 * @author Revin Roman http://phptime.ru
 */

namespace resources;

use yii\helpers\Json;

/**
 * Class Page
 * @package resources
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
class Page extends \yii\db\ActiveRecord
{

    use \components\db\traits\ActivationTrait,
        \components\db\traits\SoftDeleteTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\BlameableBehavior::className(),
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        $fields['deleted'] = 'deleted';
        $fields['activated'] = 'activated';

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
     * @return \resources\queries\PageQuery
     */
    public static function find()
    {
        return new \resources\queries\PageQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }
}