<?php
/**
 * PageEditForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Page\backend\forms;

use cookyii\modules\Page\resources\Page\Model as PageModel;
use cookyii\traits\PopulateErrorsTrait;
use yii\helpers\Json;

/**
 * Class PageEditForm
 * @package cookyii\modules\Page\backend\forms
 */
class PageEditForm extends \cookyii\base\FormModel
{

    use PopulateErrorsTrait;

    /**
     * @var PageModel
     */
    public $Page;

    public $title;
    public $slug;
    public $content;

    public $meta;

    public function init()
    {
        if (!($this->Page instanceof PageModel)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('cookyii.page', 'Not specified page to edit.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['title', 'slug', 'content'], 'string'],

            /** semantic validators */
            [['title', 'slug'], 'required'],
            [['title', 'slug'], 'filter', 'filter' => 'str_clean'],
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
            'title' => \Yii::t('cookyii.page', 'Title'),
            'slug' => \Yii::t('cookyii.page', 'Slug'),
            'content' => \Yii::t('cookyii.page', 'Content'),
            'meta["title"]' => \Yii::t('cookyii.page', 'Meta title'),
            'meta["keywords"]' => \Yii::t('cookyii.page', 'Meta keywords'),
            'meta["description"]' => \Yii::t('cookyii.page', 'Meta description'),
        ];
    }

    /**
     * @return array
     */
    public function formAction()
    {
        return ['/page/rest/page/edit'];
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
        $Page->meta = Json::encode($this->meta);

        $result = $Page->validate() && $Page->save();

        if ($Page->hasErrors()) {
            $this->populateErrors($Page, 'name');
        }

        $this->Page = $Page;

        return $result;
    }
}