<?php
/**
 * Controller.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace backend\components;

/**
 * Class Controller
 * @package backend\components
 */
abstract class Controller extends \components\web\Controller
{

    public $loader = true;

    public $layout = '//main';

    public $public = false;

    /**
     * @inheritdoc
     * @throws \yii\web\ForbiddenHttpException
     */
    public function init()
    {
        parent::init();

        $this->on(self::EVENT_BEFORE_ACTION, function (\yii\base\ActionEvent $ActionEvent) {
            $Action = $ActionEvent->action;

            if (!User()->isGuest && !in_array($Action->getUniqueId(), ['site/error'], true)) {
                /** @var \resources\Account $Account */
                $Account = User()->identity;

                if (($reason = $Account->isAvailable()) !== true) {
                    switch ($reason) {
                        case 'not-activated':
                            throw new \yii\web\ForbiddenHttpException('You account is not activated.');
                        case 'deleted':
                            throw new \yii\web\ForbiddenHttpException('You account removed.');
                    }
                }
            }
        });
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => $this->accessRules(),
            ],
        ];
    }

    /**
     * @return array
     */
    abstract protected function accessRules();
}