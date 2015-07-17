<?php

namespace crm\tests\_support;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

/**
 * Class AcceptanceHelper
 * @package crm\tests\_support
 */
class AcceptanceHelper extends \Codeception\Module
{

    public function _afterSuite()
    {
        DB()->createCommand()->delete('{{%file}}')->execute();
        DB()->createCommand()->delete('{{%session}}')->execute();
        DB()->createCommand()->resetSequence('{{%file}}')->execute();
    }
}