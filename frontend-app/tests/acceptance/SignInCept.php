<?php
/**
 * SignInCept.php
 * @author Revin Roman
 */

$fixtures = include(Yii::getAlias('@tests/fixtures/_data/account-user.php'));

$I = new erp\tests\AcceptanceTester($scenario);
$I->wantTo('check authorization');
erp\tests\_pages\AccountSignInPage::openBy($I);

$I->see('Войти');
$I->dontSee('Выйти');

$I->submitForm('#SigninForm', [
    'SigninForm' => [
        'email' => '',
        'password' => '',
    ],
]);
$I->see('Необходимо заполнить');

$key = array_rand($fixtures);
$attributes = $fixtures[$key];
$attributes['password'] = 'password_' . $key;

$I->submitForm('#SigninForm', [
    'SigninForm' => [
        'email' => $attributes['username'], // bad email
        'password' => $attributes['password'] . '123', // bad password
    ],
]);
$I->see('Вы ввели некорректный email');
$I->see('Email или пароль введены неверно');

$I->submitForm('#SigninForm', [
    'SigninForm' => [
        'email' => $attributes['email'], // good email
        'password' => $attributes['password'], // good password
    ],
]);
$I->see('Рабочий стол');