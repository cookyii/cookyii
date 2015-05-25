<?php
/**
 * Controller.php
 * @author Revin Roman http://phptime.ru
 */

namespace crm\components;

/**
 * Class Controller
 * @package crm\components
 */
class Controller extends \yii\web\Controller
{

    use \common\traits\UseSslTrait;

    public $hideLoader = false;

    public $public = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->checkUseSsl(true);

        if (isset($_GET['clear'])) {
            \Yii::$app->get('cache')->flush();
            if (function_exists('apc_clear_cache')) {
                apc_clear_cache();
            }
        }

//        if (!User()->isGuest) {
//            /** @var \resources\User $User */
//            $User = User()->identity;
//
//            if (true !== $User->isAvailable() && true !== $this->public) {
//                switch ($User->isAvailable()) {
//                    case 'not-activated':
//                        throw new \yii\web\ForbiddenHttpException(\Yii::t('account', 'Ваш аккаунт не активирован'));
//                    case 'deleted':
//                        throw new \yii\web\ForbiddenHttpException(\Yii::t('account', 'Ваш аккаунт удалён'));
//                }
//            }
//        }
    }
}