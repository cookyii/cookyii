<?php
/**
 * PageEditForm.php
 * @author Revin Roman
 */

namespace cookyii\modules\Page\backend\forms;

use yii\helpers\Json;

/**
 * Class PageEditForm
 * @package cookyii\modules\Page\backend\forms
 */
class PageEditForm extends \yii\base\Model
{

    use \cookyii\db\traits\PopulateErrorsTrait;

    /** @var \resources\Page */
    public $Page;

    public $title;
    public $slug;
    public $content;

    public $meta_title;
    public $meta_keywords;
    public $meta_description;
    public $meta_image;

    public function init()
    {
        if (!($this->Page instanceof \resources\Page)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('page', 'Not specified user to edit.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['title', 'slug', 'content', 'meta_title', 'meta_keywords', 'meta_description'], 'string'],

            /** semantic validators */
            [['title', 'slug'], 'required'],
            [['title', 'slug', 'meta_title', 'meta_keywords', 'meta_description'], 'filter', 'filter' => 'str_clean'],

            /** default values */
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => \Yii::t('page', 'Title'),
            'slug' => \Yii::t('page', 'Slug'),
            'content' => \Yii::t('page', 'Content'),
            'meta_title' => \Yii::t('page', 'Meta title'),
            'meta_keywords' => \Yii::t('page', 'Meta keywords'),
            'meta_description' => \Yii::t('page', 'Meta description'),
        ];
    }

    /**
     * @return array
     */
    public function formAction()
    {
        return ['/page/rest/edit'];
    }

    /**
     * @return bool
     */
    public function isNewPage()
    {
        return $this->Page->isNewRecord;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $Page = $this->Page;

        $Page->title = $this->title;
        $Page->slug = $this->slug;
        $Page->content = $this->content;
        $Page->meta = Json::encode([
            'title' => $this->meta_title,
            'keywords' => $this->meta_keywords,
            'description' => $this->meta_description,
            'image' => $this->meta_image,
        ]);

        $result = $Page->validate() && $Page->save();

        if ($Page->hasErrors()) {
            $this->populateErrors($Page, 'name');
        }

        $this->Page = $Page;

        return $result;
    }
}