<?php
/**
 * User.php
 * @author Revin Roman http://phptime.ru
 */

namespace backend\tests\fixtures;

use backend\modules\Account;
use yii\test\ActiveFixture;

class User extends ActiveFixture
{

    use \common\helpers\GetByIndexTrait;

    public $modelClass = Account\models\User::class;
    public $dataFile = '@tests/fixtures/_data/account-user.php';
} 