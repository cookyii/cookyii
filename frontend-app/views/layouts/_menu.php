<?php
/**
 * _menu.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 */

/** @var frontend\components\Controller $Controller */
$Controller = $this->context;

$select = isset($this->params['menu_select']) ? $this->params['menu_select'] : null;

if (User()->isGuest) {
    return [
        [
            'label' => Yii::t('app', 'Вход'),
            'url' => ['/'],
            'icon' => 'home',
            'visible' => true,
            'selected' => false,
        ],
    ];
} else {
    return [
//        [
//            'label' => Yii::t('app', 'Заказы'),
//            'icon' => 'briefcase',
//            'url' => ['/order/list/index'],
//            'selected' => $Controller->module->id === 'order',
//            'visible' => User()->can(\frontend\Permissions::ORDER_ACCESS)
//        ],

    ];
}