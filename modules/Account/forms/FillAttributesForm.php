<?php
/**
 * FillAttributesForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\forms;

use cookyii\modules\Account\resources\Account\Model as AccountModel;
use cookyii\modules\Account\resources\AccountAuthResponse\Model as AccountAuthResponseModel;
use rmrevin\yii\rbac\RbacFactory;
use yii\helpers\Json;

/**
 * Class FillAttributesForm
 * @package cookyii\modules\Account\forms
 */
class FillAttributesForm extends \cookyii\base\FormModel
{

    use \cookyii\traits\PopulateErrorsTrait;

    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        /** @var AccountModel $AccountModel */
        $AccountModel = \Yii::createObject(AccountModel::className());

        return [
            /** type validators */
            [['email'], 'string'],

            /** semantic validators */
            [['email'], 'required'],
            [['email'], 'email'],
            [['email'], 'filter', 'filter' => 'str_clean'],
            [['email'], 'unique', 'targetClass' => $AccountModel::className(), 'targetAttribute' => 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('cookyii.account', 'Email'),
        ];
    }

    /**
     * @return array
     */
    public function formAction()
    {
        return ['/account/api/fill'];
    }

    /**
     * @param \yii\authclient\ClientInterface $Client
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function save(\yii\authclient\ClientInterface $Client)
    {
        /** @var AccountModel $Account */
        $Account = \Yii::createObject(AccountModel::className());

        $Account->appendClientAttributes($Client);

        $Account->setAttributes([
            'email' => $this->email,
        ]);

        $Account->validate() && $Account->save();

        $AuthResponse = AccountAuthResponseModel::createLog($Client);

        if ($Account->hasErrors()) {
            $AuthResponse->result = Json::encode($Account->getErrors());
        } else {
            $AuthResponse->result = (string)$Account->id;

            $Account->pushSocialLink($Client);

            AuthManager()->assign(RbacFactory::Role(\common\Roles::USER), $Account->id);

            $SignInFormModel = \Yii::createObject(SignInForm::className());

            User()->login($Account, $SignInFormModel::REMEMBER_TIME);
        }

        $AuthResponse->validate() && $AuthResponse->save();

        if ($Account->hasErrors()) {
            $this->populateErrors($Account, 'name');
        }

        return !$Account->hasErrors();
    }
}
