<?php
/**
 * Page.php
 * @author Revin Roman http://phptime.ru
 */

namespace resources;

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
 * @property integer $activated
 * @property integer $deleted
 */
class Page extends \yii\db\ActiveRecord
{

    use \components\db\traits\ActivationTrait;
    use \components\db\traits\SoftDeleteTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['slug', 'title', 'content', 'meta'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['activated', 'deleted'], 'boolean'],

            /** semantic validators */
            [['slug'], 'unique', 'filter' => $this->isNewRecord ? null : ['not', ['id' => $this->id]]],
            [['slug', 'title'], 'required'],
            [['slug', 'title'], 'filter', 'filter' => 'str_clean'],
            [['activated'], 'in', 'range' => [static::NOT_ACTIVATED, static::ACTIVATED]],
            [['deleted'], 'in', 'range' => [static::NOT_DELETED, static::DELETED]],

            /** default values */
            [['activated'], 'default', 'value' => static::NOT_ACTIVATED],
            [['deleted'], 'default', 'value' => static::NOT_DELETED],
        ];
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

    const NOT_DELETED = 0;
    const DELETED = 1;

    const NOT_ACTIVATED = 0;
    const ACTIVATED = 1;
}