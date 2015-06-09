<?php
/**
 * User.php
 * @author Revin Roman
 */

namespace frontend\tests\fixtures;

use frontend\modules\Account;
use yii\test\ActiveFixture;

class User extends ActiveFixture
{

    use \common\helpers\GetByIndexTrait;

    public $modelClass = Account\models\User::class;
    public $dataFile = '@tests/fixtures/_data/account-user.php';
} 