<?php
/**
 * SectionEditForm.php
 * @author Revin Roman
 */

namespace cookyii\modules\Feed\backend\forms;

use yii\helpers\Json;

/**
 * Class SectionEditForm
 * @package cookyii\modules\Feed\backend\forms
 */
class SectionEditForm extends \yii\base\Model
{

    use \cookyii\db\traits\PopulateErrorsTrait;

    /** @var \resources\Feed\Section */
    public $Section;

    public $parent_id;
    public $slug;
    public $title;
    public $sort;

    public $published_at;
    public $archived_at;

    public $meta_title;
    public $meta_keywords;
    public $meta_description;
    public $meta_image;

    public function init()
    {
        if (!($this->Section instanceof \resources\Feed\Section)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('feed', 'Not specified section to edit.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['slug', 'title', 'meta_title', 'meta_keywords', 'meta_description', 'published_at', 'archived_at'], 'string'],
            [['parent_id', 'sort'], 'integer'],

            /** semantic validators */
            [['slug', 'title'], 'required'],
            [['slug', 'title', 'meta_title', 'meta_keywords', 'meta_description'], 'filter', 'filter' => 'str_clean'],

            /** default values */
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => \Yii::t('feed', 'Parent section'),
            'slug' => \Yii::t('feed', 'Slug'),
            'title' => \Yii::t('feed', 'Title'),
            'sort' => \Yii::t('feed', 'Sort'),
            'published_at' => \Yii::t('feed', 'Start publishing at'),
            'archived_at' => \Yii::t('feed', 'End publishing at'),
            'meta_title' => \Yii::t('feed', 'Meta title'),
            'meta_keywords' => \Yii::t('feed', 'Meta keywords'),
            'meta_description' => \Yii::t('feed', 'Meta description'),
        ];
    }

    /**
     * @return array
     */
    public function formAction()
    {
        return ['/feed/section/rest/section/edit'];
    }

    /**
     * @return bool
     */
    public function isNewSection()
    {
        return $this->Section->isNewRecord;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $Section = $this->Section;

        $Section->parent_id = $this->parent_id;
        $Section->title = $this->title;
        $Section->slug = $this->slug;
        $Section->sort = $this->sort;
        $Section->published_at = empty($this->published_at) ? time() : strtotime($this->published_at);
        $Section->archived_at = empty($this->archived_at) ? null : strtotime($this->archived_at);
        $Section->meta = Json::encode([
            'title' => $this->meta_title,
            'keywords' => $this->meta_keywords,
            'description' => $this->meta_description,
            'image' => $this->meta_image,
        ]);

        $result = $Section->validate() && $Section->save();

        if ($Section->hasErrors()) {
            $this->populateErrors($Section, 'title');
        }

        $this->Section = $Section;

        return $result;
    }
}