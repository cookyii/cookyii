<?php
/**
 * Controller.php
 * @author Revin Roman
 */

namespace backend\components;

/**
 * Class Controller
 * @package backend\components
 */
class Controller extends \yii\web\Controller
{

    public $loader = true;

    public $layout = '//main';

    public $public = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (isset($_GET['clear'])) {
            Cache()->flush();
            Cache('authManager')->flush();
            Cache('schema')->flush();
            Cache('query')->flush();
        }

        if (!$this->public) {
            if (User()->isGuest) {
                User()->loginRequired();
            } else {
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

                if (!User()->can(\backend\Permissions::ACCESS)) {
                    throw new \yii\web\ForbiddenHttpException('Access denied.');
                }
            }
        }
    }
}