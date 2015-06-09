<?php

namespace backend\tests\_pages;

use yii\codeception\BasePage;

/**
 * @property \backend\tests\AcceptanceTester|\backend\tests\FunctionalTester $actor
 */
class AccountSignInPage extends BasePage
{

    public $route = 'account/sign/in';
}
