<?php
/**
 * SectionEditForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\forms;

use yii\helpers\Json;

/**
 * Class SectionEditForm
 * @package cookyii\modules\Feed\backend\forms
 */
class SectionEditForm extends \cookyii\base\FormModel
{

    use \cookyii\traits\PopulateErrorsTrait;

    /** @var \cookyii\modules\Feed\resources\FeedSection */
    public $Section;

    public $parent_id;
    public $slug;
    public $title;
    public $sort;

    public $published_at;
    public $archived_at;

    public $meta;

    public function init()
    {
        if (!($this->Section instanceof \cookyii\modules\Feed\resources\FeedSection)) {
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
            [['slug', 'title', 'published_at', 'archived_at'], 'string'],
            [['parent_id', 'sort'], 'integer'],

            /** semantic validators */
            [['slug', 'title'], 'required'],
            [['slug', 'title'], 'filter', 'filter' => 'str_clean'],
            [['meta'], 'safe'],

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
            'meta["title"]' => \Yii::t('feed', 'Meta title'),
            'meta["keywords"]' => \Yii::t('feed', 'Meta keywords'),
            'meta["description"]' => \Yii::t('feed', 'Meta description'),
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
        $Section->meta = Json::encode($this->meta);

        $result = $Section->validate() && $Section->save();

        if ($Section->hasErrors()) {
            $this->populateErrors($Section, 'title');
        }

        $this->Section = $Section;

        return $result;
    }
}