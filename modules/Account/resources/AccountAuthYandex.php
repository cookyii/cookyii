<?php
/**
 * AccountAuthYandex.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\resources;

/**
 * Class AccountAuthYandex
 * @package cookyii\modules\Account\resources
 */
class AccountAuthYandex extends AbstractAccountAuth
{

    /**
     * @return \cookyii\modules\Account\resources\queries\AccountYandexQuery
     */
    public static function find()
    {
        return \Yii::createObject(
            \cookyii\modules\Account\resources\queries\AccountYandexQuery::className(), [
                get_called_class(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_auth_yandex}}';
    }
}