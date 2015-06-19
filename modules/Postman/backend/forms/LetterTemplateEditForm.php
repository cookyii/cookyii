<?php
/**
 * LetterTemplateEditForm.php
 * @author Revin Roman
 */

namespace cookyii\modules\Postman\backend\forms;

use yii\helpers\Json;

/**
 * Class LetterTemplateEditForm
 * @package cookyii\modules\Postman\backend\forms
 */
class LetterTemplateEditForm extends \yii\base\Model
{

    use \components\db\traits\PopulateErrorsTrait;

    /** @var \resources\Letter\Template */
    public $Template;

    public $code;
    public $subject;
    public $content_text;
    public $content_html;
    public $address;
    public $params;
    public $description;
    public $use_layout;

    public function init()
    {
        if (!($this->Template instanceof \resources\Letter\Template)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('postman', 'Not specified template to edit.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['code', 'subject', 'content_text', 'content_html', 'description'], 'string'],
            [['use_layout'], 'boolean'],

            /** semantic validators */
            [['code', 'subject'], 'required'],
            [['code', 'subject', 'content_text', 'address', 'params', 'description'], 'filter', 'filter' => 'str_clean'],
            [['content_html'], 'filter', 'filter' => 'trim'],
            [['address', 'params'], 'safe'],

            /** default values */
            [['use_layout'], 'default', 'value' => \resources\Letter\Template::USE_LAYOUT],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => \Yii::t('postman', 'Code'),
            'subject' => \Yii::t('postman', 'Subject '),
            'content_text' => \Yii::t('postman', 'Plain content'),
            'content_html' => \Yii::t('postman', 'HTML content'),
            'address' => \Yii::t('postman', 'Address'),
            'params' => \Yii::t('postman', 'Parameters'),
            'description' => \Yii::t('postman', 'Description'),
            'use_layout' => \Yii::t('postman', 'Use layout'),
        ];
    }

    /**
     * @return array
     */
    public function formAction()
    {
        return ['/postman/rest/edit'];
    }

    /**
     * @return bool
     */
    public function isNewTemplate()
    {
        return $this->Template->isNewRecord;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $Template = $this->Template;

        $Template->code = $this->code;
        $Template->subject = $this->subject;
        $Template->content_text = $this->content_text;
        $Template->content_html = $this->content_html;
        $Template->address = Json::encode($this->address);
        $Template->params = Json::encode($this->params);
        $Template->description = $this->description;
        $Template->use_layout = $this->use_layout;

        if ($Template->isNewRecord) {
            $Template->deleted = \resources\Letter\Template::NOT_DELETED;
        }

        $result = $Template->validate() && $Template->save();

        if ($Template->hasErrors()) {
            $this->populateErrors($Template, 'code');
        }

        $this->Template = $Template;

        return $result;
    }
}