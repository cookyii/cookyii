<?php

class m150715_122741_client_demo_data extends \cookyii\db\Migration
{

    public function up()
    {
        if (!YII_DEMO_DATA) {
            echo 'm150715_122741_client_demo_data skipped.' . PHP_EOL;

            return true;
        }

        $time = time();

        $faker = \Faker\Factory::create();

        $this->insert('{{%client}}', [
            'name' => sprintf('%s %s', $faker->lastName, $faker->firstNameMale),
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
            'created_at' => $time,
            'updated_at' => $time,
        ]);

        $client_id = $this->db->lastInsertID;

        $this->insert('{{%client_property}}', [
            'client_id' => $client_id,
            'key' => 'gender',
            'value' => '1',
        ]);

        $this->insert('{{%client_property}}', [
            'client_id' => $client_id,
            'key' => 'city',
            'value' => 'Moscow',
        ]);

        $this->insert('{{%client}}', [
            'name' => sprintf('%s %s', $faker->lastName, $faker->firstNameFemale),
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
            'created_at' => $time,
            'updated_at' => $time,
        ]);

        $client_id = $this->db->lastInsertID;

        $this->insert('{{%client_property}}', [
            'client_id' => $client_id,
            'key' => 'gender',
            'value' => '0',
        ]);
    }

    public function down()
    {
        echo "m150715_122741_client_demo_data reverted.\n";

        return true;
    }
}