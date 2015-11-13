<?php

use yii\db\Schema;

class m151113_203716_account_social_token extends \cookyii\db\Migration
{

    static $socials = ['facebook', 'github', 'google', 'linkedin', 'live', 'twitter', 'vkontakte', 'yandex'];

    public function up()
    {
        foreach (static::$socials as $social) {
            $this->addColumn('{{%account_auth_' . $social . '}}', 'token', Schema::TYPE_TEXT);
        }
    }

    public function down()
    {
        foreach (static::$socials as $social) {
            $this->dropColumn('{{%account_auth_' . $social . '}}', 'token', Schema::TYPE_TEXT);
        }
    }
}