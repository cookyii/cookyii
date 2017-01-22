<?php
/**
 * FillAttributesForm.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\forms;

use cookyii\Decorator as D;
use cookyii\modules\Account;
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

    public $accountModule = 'account';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        /** @var AccountModel $AccountModel */
        $AccountModel = \Yii::createObject(AccountModel::class);

        return [
            /** type validators */
            [['email'], 'string'],

            /** semantic validators */
            [['email'], 'required'],
            [['email'], 'email'],
            [['email'], 'filter', 'filter' => 'str_clean'],
            [
                ['email'], 'unique',
                'targetClass' => get_class($AccountModel),
                'targetAttribute' => 'email',
            ],
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
        /** @var Account\backend\Module $Module */
        $Module = \Yii::$app->getModule($this->accountModule);
        $roles = $Module->roles;

        /** @var AccountModel $Account */
        $Account = \Yii::createObject(AccountModel::class);

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

            D::AuthManager()->assign(RbacFactory::Role($roles['user']), $Account->id);

            $SignInFormModel = \Yii::createObject(SignInForm::class);

            D::User()->login($Account, $SignInFormModel::REMEMBER_TIME);
        }

        $AuthResponse->validate() && $AuthResponse->save();

        if ($Account->hasErrors()) {
            $this->populateErrors($Account, 'name');
        }

        return !$Account->hasErrors();
    }
}
