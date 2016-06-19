<?php

class m160115_202234_account_merging_auth_tables extends \cookyii\db\Migration
{

    static $providers = ['facebook', 'github', 'google', 'linkedin', 'live', 'twitter', 'vkontakte', 'yandex'];

    public function up()
    {
        $this->createTable('{{%account_auth}}', [
            'schema' => [
                'social_type' => $this->string(),
                'social_id' => $this->string(),
                'account_id' => $this->integer(),
                'token' => $this->text(),
                'PRIMARY KEY ([[social_type]], [[social_id]], [[account_id]])',
            ],
            'indexes' => [
                'idx_account' => ['account_id'],
            ],
            'fkeys' => [
                'fkey_account_auth_account' => [
                    'from' => 'account_id',
                    'to' => ['{{%account}}', 'id'],
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ],
            ],
        ]);

        foreach (static::$providers as $provider) {
            $table = "{{%account_auth_$provider}}";

            $data = (new \yii\db\Query)
                ->select('*')
                ->from($table)
                ->all();

            $this->dropTable($table);

            $values = [];
            if (!empty($data)) {
                foreach ($data as $row) {
                    $values[] = [$provider, $row['social_id'], $row['account_id'], $row['token']];
                }
            }

            if (!empty($values)) {
                $this->batchInsert('{{%account_auth}}', ['social_type', 'social_id', 'account_id', 'token'], $values);
            }
        }
    }

    public function down()
    {
        $data = (new \yii\db\Query)
            ->select('*')
            ->from('{{%account_auth}}')
            ->all();

        $this->dropForeignKey('fkey_account_auth_account', '{{%account_auth}}');

        $this->dropTable('{{%account_auth}}');

        foreach (static::$providers as $provider) {
            $table = '{{%account_auth_' . $provider . '}}';

            $this->createTable($table, [
                'schema' => [
                    'account_id' => $this->integer(),
                    'social_id' => $this->string(),
                    'token' => $this->text(),
                    'PRIMARY KEY ([[account_id]], [[social_id]])',
                ],
                'indexes' => [
                    'idx_account' => ['account_id'],
                ],
                'fkeys' => [
                    "fkey_account_auth_{$provider}_account" => [
                        'from' => 'account_id',
                        'to' => ['{{%account}}', 'id'],
                        'delete' => 'CASCADE',
                        'update' => 'CASCADE',
                    ],
                ],
            ]);

            $values = [];
            if (!empty($data)) {
                foreach ($data as $row) {
                    if ($row['social_type'] === $provider) {
                        $values[] = [
                            $row['account_id'],
                            $row['social_id'],
                            $row['token'],
                        ];
                    }
                }
            }

            if (!empty($values)) {
                $this->batchInsert('{{%account_auth_' . $provider . '}}', ['account_id', 'social_id', 'token'], $values);
            }
        }
    }
}