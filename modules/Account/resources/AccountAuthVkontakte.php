<?php
/**
 * AccountAuthVkontakte.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthVkontakte
 * @package cookyii\modules\Account\resources
 */
class AccountAuthVkontakte extends AbstractAccountAuth
{

    /**
     * @return \cookyii\modules\Account\resources\queries\AccountVkontakteQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Account\resources\queries\AccountVkontakteQuery::className(), [
                get_called_class(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_vkontakte}}';
    }
}