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

    use \components\db\traits\PopulateErrorsTrait;

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
        return ['/feed/section/rest/edit'];
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
            'meta_title' => $this->meta_title,
            'meta_keywords' => $this->meta_keywords,
            'meta_description' => $this->meta_description,
            'meta_image' => $this->meta_image,
        ]);

        if ($Section->isNewRecord) {
            $Section->activated = \resources\Feed\Section::NOT_ACTIVATED;
            $Section->deleted = \resources\Feed\Section::NOT_DELETED;
        }

        $result = $Section->validate() && $Section->save();

        if ($Section->hasErrors()) {
            $this->populateErrors($Section, 'title');
        }

        $this->Section = $Section;

        return $result;
    }

    /**
     * @param integer $parent_section_id
     * @param integer $step
     * @return mixed
     */
    public function getNextSort($parent_section_id, $step = 100)
    {

    }

    /**
     * @param array|null $items
     * @param array|null $options
     * @param array|null $sections
     * @param integer $nested
     * @return array
     */
    public function getParentValues($items = null, $options = null, $sections = null, $nested = 1)
    {
        if (empty($items)) {
            $items = [null => 'Root section'];
        }

        if (empty($options)) {
            $options = [];
        }

        if (empty($sections)) {
            list($sections, $slugs) = \resources\Feed\Section::getTree();
        }

        if (!empty($sections)) {
            foreach ($sections as $section) {
                $items[$section['id']] = sprintf('%s %s', str_repeat('....', $nested), $section['title']);
                $options[(string)$section['id']] = ['ng-disabled' => sprintf('isSectionDisabled("%s")', $section['slug'])];
                if (!empty($section['sections'])) {
                    list($items, $options) = $this->getParentValues($items, $options, $section['sections'], $nested + 1);
                }
            }
        }

        return [$items, $options];
    }
}