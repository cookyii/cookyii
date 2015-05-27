<?php
/**
 * account-user.php
 * @author Revin Roman http://phptime.ru
 *
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use backend\modules\Account;

return [
    'id' => $index + 1,
    'username' => $faker->userName,
    'gender' => Account\models\User::MALE,
    'activated' => Account\models\User::ACTIVATED,
    'deleted' => Account\models\User::NOT_DELETED,
    'email' => $faker->email,
    'auth_key' => Security()->generateRandomString(),
    'password_hash' => Security()->generatePasswordHash('password_' . $index),
    'created_at' => time(),
    'updated_at' => time(),
];