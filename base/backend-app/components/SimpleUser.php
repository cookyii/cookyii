<?php
/**
 * SimpleUser.php
 * @author Revin Roman http://phptime.ru
 */

namespace backend\components;

/**
 * Class SimpleUser
 * @package backend\components
 */
class SimpleUser extends \yii\base\Model implements \yii\web\IdentityInterface
{

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return new self;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new \yii\base\NotSupportedException;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return 1;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return sha1('authkey');
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}