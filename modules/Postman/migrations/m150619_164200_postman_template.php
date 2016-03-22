<?php

use yii\helpers\Json;

class m150619_164200_postman_template extends \cookyii\db\Migration
{

    public function up()
    {
        $this->createTable('{{%postman_template}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'subject' => $this->text(),
            'content_text' => $this->text(),
            'content_html' => $this->text(),
            'styles' => $this->text(),
            'description' => $this->text(),
            'address' => $this->text(),
            'params' => $this->text(),
            'use_layout' => $this->boolean()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);

        $this->createIndex('idx_postman_t_code', '{{%postman_template}}', ['code'], true);

        $this->createTable('{{%postman_template_attach}}', [
            'template_id' => $this->integer(),
            'media_id' => $this->integer(),
            'embed' => $this->boolean(),
        ]);

        $this->addPrimaryKey('pk', '{{%postman_template_attach}}', ['template_id', 'media_id']);

        $this->addForeignKey('fkey_postman_template_attach_template', '{{%postman_template_attach}}', 'template_id', '{{%postman_template}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fkey_postman_template_attach_media', '{{%postman_template_attach}}', 'media_id', '{{%media}}', 'id', 'CASCADE', 'CASCADE');

        $this->insertLayoutMessage();
    }

    public function down()
    {
        $this->dropForeignKey('fkey_postman_template_attach_media', '{{%postman_template_attach}}');
        $this->dropForeignKey('fkey_postman_template_attach_template', '{{%postman_template_attach}}');

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