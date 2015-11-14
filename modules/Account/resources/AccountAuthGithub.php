<?php
/**
 * AccountAuthGithub.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthGithub
 * @package cookyii\modules\Account\resources
 */
class AccountAuthGithub extends AbstractAccountAuth
{

    /**
     * @return \cookyii\modules\Account\resources\queries\AccountGithubQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Account\resources\queries\AccountGithubQuery::className(), [
                get_called_class(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_github}}';
    }
}