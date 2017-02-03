<?php
/**
 * Controller.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace backend\components;

use cookyii\Facade as F;

/**
 * Class Controller
 * @package backend\components
 */
abstract class Controller extends \cookyii\web\Controller
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

            if (!F::User()->isGuest && !in_array($Action->getUniqueId(), ['site/error'], true)) {
                $Account = F::Account();

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
}