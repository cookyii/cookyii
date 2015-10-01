<?php
/**
 * ClientEditForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\crm\forms;

/**
 * Class ClientEditForm
 * @package cookyii\modules\Client\crm\forms
 */
class ClientEditForm extends \cookyii\base\FormModel
{

    use \cookyii\db\traits\PopulateErrorsTrait;

    /** @var \cookyii\modules\Client\resources\Client */
    public $Client;

    public $name;
    public $email;
    public $phone;

    public function init()
    {
        if (!($this->Client instanceof \cookyii\modules\Client\resources\Client)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('client', 'Not specified client to edit.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /** type validators */
            [['name', 'email', 'phone'], 'string'],

            /** semantic validators */
            [['name'], 'required'],
            [['email'], 'email'],
            [['name', 'email'], 'filter', 'filter' => 'str_clean'],

            /** default values */
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('client', 'Username'),
            'email' => \Yii::t('client', 'Email'),
            'phone' => \Yii::t('client', 'Phone'),
        ];
    }

    /**
     * @return array
     */
    public function formAction()
    {
        return ['/client/rest/client/edit'];
    }

    /**
     * @return bool
     */
    public function isNewClient()
    {
        return $this->Client->isNewRecord;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $Client = $this->Client;

        \Yii::warning($Client->isNewRecord);

        $Client->name = $this->name;
        $Client->email = $this->email;
        $Client->phone = $this->phone;

        $result = $Client->validate() && $Client->save();

        if ($Client->hasErrors()) {
            $this->populateErrors($Client, 'name');
        }

        if (AuthManager() instanceof \yii\rbac\DbManager) {
            AuthManager()->invalidateCache();
        }

        $this->Client = $Client;

        return $result;
    }
}