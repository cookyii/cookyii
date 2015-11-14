<?php
/**
 * AccountAuthLinkedin.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthLinkedin
 * @package cookyii\modules\Account\resources
 */
class AccountAuthLinkedin extends AbstractSocial
{

    /**
     * @return \cookyii\modules\Account\resources\queries\AccountLinkedinQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Account\resources\queries\AccountLinkedinQuery::className(), [
                get_called_class(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_linkedin}}';
    }
}