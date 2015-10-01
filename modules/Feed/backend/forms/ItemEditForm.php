<?php
/**
 * ItemEditForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Feed\backend\forms;

use cookyii\modules\Feed;
use yii\helpers\Json;

/**
 * Class ItemEditForm
 * @package cookyii\modules\Feed\backend\forms
 */
class ItemEditForm extends \cookyii\base\FormModel
{

    use \cookyii\db\traits\PopulateErrorsTrait;

    /** @var \cookyii\modules\Feed\resources\Feed\Item */
    public $Item;

    public $slug;
    public $title;
    public $sort;

    public $content_preview;
    public $content_detail;

    public $sections;

    public $published_at;
    public $archived_at;

    public $meta;

    public function init()
    {
        if (!($this->Item instanceof \cookyii\modules\Feed\resources\Feed\Item)) {
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
            [['slug', 'title', 'content_preview', 'content_detail', 'published_at', 'archived_at'], 'string'],
            [['sort'], 'integer'],
            [['sections'], 'each', 'rule' => ['integer']],

            /** semantic validators */
            [['slug', 'title', 'sections'], 'required'],
            [['slug', 'title'], 'filter', 'filter' => 'str_clean'],
            [['content_preview', 'content_detail'], 'filter', 'filter' => 'str_pretty'],
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
            'slug' => \Yii::t('feed', 'Slug'),
            'title' => \Yii::t('feed', 'Title'),
            'sort' => \Yii::t('feed', 'Sort'),
            'sections' => \Yii::t('feed', 'Sections'),
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
        return ['/feed/item/rest/item/edit'];
    }

    /**
     * @return bool
     */
    public function isNewItem()
    {
        return $this->Item->isNewRecord;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $Item = $this->Item;

        $Item->title = $this->title;
        $Item->slug = $this->slug;
        $Item->sort = $this->sort;
        $Item->content_preview = $this->content_preview;
        $Item->content_detail = $this->content_detail;
        $Item->published_at = empty($this->published_at) ? time() : strtotime($this->published_at);
        $Item->archived_at = empty($this->archived_at) ? null : strtotime($this->archived_at);
        $Item->meta = Json::encode($this->meta);

        $result = $Item->validate() && $Item->save();

        if ($Item->hasErrors()) {
            $this->populateErrors($Item, 'title');
        } else {
            /** @var Feed\resources\Feed\ItemSection $ItemSectionModel */
            $ItemSectionModel = \Yii::createObject(Feed\resources\Feed\ItemSection::className());

            $ItemSectionModel::deleteAll(['item_id' => $Item->id]);

            if (!empty($this->sections)) {
                foreach ($this->sections as $section) {
                    $ItemSection = $ItemSectionModel;
                    $ItemSection->item_id = $Item->id;
                    $ItemSection->section_id = $section;
                    $ItemSection->validate() && $ItemSection->save();
                }
            }
        }

        $this->Item = $Item;

        return $result;
    }
}