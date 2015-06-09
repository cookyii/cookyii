<?php
/**
 * Controller.php
 * @author Revin Roman
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
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                    'application/xml' => \yii\web\Response::FORMAT_XML,
                ],
            ],
            'verbFilter' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => $this->verbs(),
            ],

            'authenticator' => [
                'class' => 'yii\filters\auth\CompositeAuth',
//                'class' => 'yii\filters\auth\HttpBearerAuth',
            ],
            'rateLimiter' => [
                'class' => 'yii\filters\RateLimiter',
            ],
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => $this->accessRules(),
            ],
        ];
    }

    /**
     * @return array
     */
    abstract protected function accessRules();
}