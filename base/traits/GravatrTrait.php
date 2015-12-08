<?php
/**
 * GravatrTrait.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\traits;

/**
 * Class GravatrTrait
 * @package cookyii\traits
 *
 * @property string $email
 */
trait GravatrTrait
{

    public static $gravatarParams = [
        'r' => 'r',
        's' => 128,
        'd' => 'retro',
    ];

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function getGravatar()
    {
        if (!($this instanceof \yii\db\ActiveRecord)) {
            throw new \yii\base\Exception(\Yii::t('cookyii', 'Model must be `{class}`.', [
                'attribute' => 'ActiveRecord',
            ]));
        }

        if (!$this->hasAttribute('email')) {
            throw new \yii\base\Exception(\Yii::t('cookyii', 'Model must contain an attribute `{attribute}`.', [
                'attribute' => 'email',
            ]));
        }

        $hash = md5(strtolower(trim($this->email)));

        $params = array_merge([
            'r' => 'r',
            's' => 128,
            'd' => 'retro',
        ], static::$gravatarParams);

        return sprintf('https://secure.gravatar.com/avatar/%s.png?%s', $hash, http_build_query($params));
    }
}