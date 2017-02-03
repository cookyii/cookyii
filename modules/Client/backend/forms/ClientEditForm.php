<?php
/**
 * ClientEditForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\backend\forms;

use cookyii\Facade as F;
use cookyii\modules\Client\resources\Client\Model as ClientModel;
use cookyii\traits\PopulateErrorsTrait;

/**
 * Class ClientEditForm
 * @package cookyii\modules\Client\backend\forms
 */
class ClientEditForm extends \cookyii\base\FormModel
{

    use PopulateErrorsTrait;

    /**
     * @var ClientModel
     */
    public $Client;

    public $name;
    public $email;
    public $phone;

    public function init()
    {
        if (!($this->Client instanceof ClientModel)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('cookyii.client', 'Not specified client to edit.'));
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
            'name' => \Yii::t('cookyii.client', 'Username'),
            'email' => \Yii::t('cookyii.client', 'Email'),
            'phone' => \Yii::t('cookyii.client', 'Phone'),
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

        if (F::AuthManager() instanceof \yii\rbac\DbManager) {
            F::AuthManager()->invalidateCache();
        }

        $this->Client = $Client;

        return $result;
    }
}