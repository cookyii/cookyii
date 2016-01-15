<?php

use yii\db\Schema;

class m151113_203716_account_social_token extends \cookyii\db\Migration
{

    static $providers = ['facebook', 'github', 'google', 'linkedin', 'live', 'twitter', 'vkontakte', 'yandex'];

    public function up()
    {
        foreach (static::$providers as $provider) {
            $this->addColumn('{{%account_auth_' . $provider . '}}', 'token', Schema::TYPE_TEXT);
        }
    }

    public function down()
    {
        foreach (static::$providers as $provider) {
            $this->dropColumn('{{%account_auth_' . $provider . '}}', 'token', Schema::TYPE_TEXT);
        }
    }
}