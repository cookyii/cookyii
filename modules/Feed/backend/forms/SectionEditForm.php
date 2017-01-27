<?php
/**
 * SectionEditForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\forms;

use cookyii\modules\Feed\resources\FeedSection\Model as FeedSectionModel;
use cookyii\traits\PopulateErrorsTrait;
use yii\helpers\Json;

/**
 * Class SectionEditForm
 * @package cookyii\modules\Feed\backend\forms
 */
class SectionEditForm extends \cookyii\base\FormModel
{

    use PopulateErrorsTrait;

    /**
     * @var FeedSectionModel
     */
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
        if (!($this->Section instanceof FeedSectionModel)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('cookyii.feed', 'Not specified section to edit.'));
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
            'parent_id' => \Yii::t('cookyii.feed', 'Parent section'),
            'slug' => \Yii::t('cookyii.feed', 'Slug'),
            'title' => \Yii::t('cookyii.feed', 'Title'),
            'sort' => \Yii::t('cookyii.feed', 'Sort'),
            'published_at' => \Yii::t('cookyii.feed', 'Start publishing at'),
            'archived_at' => \Yii::t('cookyii.feed', 'End publishing at'),
            'meta["title"]' => \Yii::t('cookyii.feed', 'Meta title'),
            'meta["keywords"]' => \Yii::t('cookyii.feed', 'Meta keywords'),
            'meta["description"]' => \Yii::t('cookyii.feed', 'Meta description'),
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
