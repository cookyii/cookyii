<?php

use yii\db\Schema;
use yii\helpers\Json;

class m150619_164200_postman_template extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%postman_template}}', [
            'id' => Schema::TYPE_PK,
            'code' => Schema::TYPE_STRING,
            'subject' => Schema::TYPE_TEXT,
            'content_text' => Schema::TYPE_TEXT,
            'content_html' => Schema::TYPE_TEXT,
            'styles' => Schema::TYPE_TEXT,
            'description' => Schema::TYPE_TEXT,
            'address' => Schema::TYPE_TEXT,
            'params' => Schema::TYPE_TEXT,
            'use_layout' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 1',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'deleted_at' => Schema::TYPE_INTEGER,
        ]);

        $this->createIndex('idx_code', '{{%postman_template}}', ['code'], true);

        $this->createTable('{{%postman_template_attach}}', [
            'template_id' => Schema::TYPE_INTEGER,
            'media_id' => Schema::TYPE_INTEGER,
            'embed' => Schema::TYPE_BOOLEAN,
            'PRIMARY KEY (`template_id`, `media_id`)',
            'FOREIGN KEY (template_id) REFERENCES {{%postman_template}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (media_id) REFERENCES {{%media}} (id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);

        $this->insertLayoutMessage();
    }

    public function down()
    {
        $this->dropTable('{{%postman_template_attach}}');
        $this->dropTable('{{%postman_template}}');
    }

    protected function insertLayoutMessage()
    {
        $time = time();

        $params = [
            [
                'key' => 'content',
                'description' => 'Message content',
            ],
        ];

        $content = [
            'text' => 'Hello {username},' . PHP_EOL
                . '---------------' . PHP_EOL
                . '{content}' . PHP_EOL
                . PHP_EOL
                . 'Good bye!',
            'html' => '<html>' . PHP_EOL
                . '<head>' . PHP_EOL
                . '    <title>{subject}</title>' . PHP_EOL
                . '</head>' . PHP_EOL
                . '<body>' . PHP_EOL
                . '    <div style="font-weight: bold;">Hello {username},</div>' . PHP_EOL
                . '    <div>{content}</div>' . PHP_EOL
                . '    <br>' . PHP_EOL
                . '    <div style="font-size: 0.9em; color: #919191;">Good bye!</div>' . PHP_EOL
                . '</body>' . PHP_EOL
                . '</html>',
        ];

        $this->insert('{{%postman_template}}', [
            'code' => '.layout',
            'subject' => 'Base layout for message',
            'content_text' => $content['text'],
            'content_html' => $content['html'],
            'styles' => null,
            'description' => 'This is a special template that is a wrapper for all letters.',
            'params' => Json::encode($params),
            'address' => null,
            'use_layout' => 0,
            'created_at' => $time,
            'updated_at' => $time,
        ]);
    }
}