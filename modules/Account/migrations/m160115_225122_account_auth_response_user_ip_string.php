<?php

class m160115_225122_account_auth_response_user_ip_string extends \cookyii\db\Migration
{

    public function up()
    {
        $data = (new yii\db\Query)
            ->select('*')
            ->from('{{%account_auth_response}}')
            ->all($this->db);

        $this->alterColumn('{{%account_auth_response}}', 'user_ip', $this->string());

        if (!empty($data)) {
            foreach ($data as $row) {
                $this->update(
                    '{{%account_auth_response}}',
                    ['user_ip' => long2ip($row['user_ip'])],
                    ['id' => $row['id']]
                );
            }
        }
    }

    public function down()
    {
        $data = (new yii\db\Query)
            ->select('*')
            ->from('{{%account_auth_response}}')
            ->all($this->db);

        $this->update(
            '{{%account_auth_response}}',
            ['user_ip' => null]
        );

        $this->alterColumn('{{%account_auth_response}}', 'user_ip', $this->integer());

        if (!empty($data)) {
            foreach ($data as $row) {
                $this->update(
                    '{{%account_auth_response}}',
                    ['user_ip' => ip2long($row['user_ip'])],
                    ['id' => $row['id']]
                );
            }
        }
    }
}
