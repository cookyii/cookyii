<?php
/**
 * _menu-right.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

use cookyii\Facade as F;

$menu = [];

if (F::User()->isGuest) {
    $menu[] = [
        'label' => Yii::t('app', 'Sign in'),
        'url' => ['/account/sign/in'],
        'icon' => 'sign-in',
        'visible' => true,
        'selected' => false,
    ];
    $menu[] = [
        'label' => Yii::t('app', 'Sign up'),
        'url' => ['/account/sign/up'],
        'icon' => 'user',
        'visible' => true,
        'selected' => false,
    ];
} else {
    $Account = F::Account();

    $menu[] = [
        'label' => $Account->name,
        'url' => '#',
        'icon' => 'user',
        'visible' => true,
        'selected' => false,
    ];
    $menu[] = [
        'label' => Yii::t('app', 'Sign out'),
        'url' => ['/account/sign/out'],
        'icon' => 'sign-out',
        'visible' => true,
        'selected' => false,
    ];
}

return $menu;