<?php
/**
 * Controller.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\rest;

/**
 * Class Controller
 * @package common\rest
 */
abstract class Controller extends \yii\rest\Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                    'application/xml' => \yii\web\Response::FORMAT_XML,
                ],
            ],
            'verbFilter' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => $this->verbs(),
            ],

            'authenticator' => [
                'class' => \yii\filters\auth\CompositeAuth::class,
//                'class' => HttpBearerAuth::class,
            ],
            'rateLimiter' => [
                'class' => \yii\filters\RateLimiter::class,
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => $this->accessRules(),
            ],
        ];
    }

    /**
     * @return array
     */
    abstract protected function accessRules();
}