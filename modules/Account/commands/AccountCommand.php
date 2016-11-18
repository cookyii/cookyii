<?php
/**
 * AccountCommand.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Account\commands;

use cookyii\modules\Account;
use cookyii\modules\Account\resources\Account\Model as AccountModel;
use rmrevin\yii\rbac\RbacFactory;
use yii\helpers\Console;

/**
 * Class AccountCommand
 * @package cookyii\modules\Account\commands
 */
class AccountCommand extends \yii\console\Controller
{

    /**
     * @var string
     */
    public $accountModule = 'account';

    /**
     * @param string $email
     * @param string $name
     * @param string $pass
     * @return int
     */
    public function actionAdd($email = '', $name = '', $pass = '')
    {
        /** @var Account\backend\Module $Module */
        $Module = \Yii::$app->getModule($this->accountModule);
        $roles = $Module->roles;

        if (empty($email)) {
            $email = $this->prompt('Enter user email:', [
                'required' => true,
            ]);
        }

        if (empty($name)) {
            $name = $this->prompt('Enter user name:', [
                'required' => true,
            ]);
        }

        if (empty($pass)) {
            $pass = $this->prompt('Enter user password:', [
                'required' => true,
            ]);
        }

        /** @var AccountModel $Account */
        $Account = \Yii::createObject(AccountModel::class);
        $Account->setAttributes([
            'name' => $name,
            'email' => $email,
            'password' => $pass,
            'activated_at' => time(),
        ]);

        $Account->save();
        if (!$Account->hasErrors()) {
            AuthManager()->assign(RbacFactory::Role($roles['user']), $Account->id);
            AuthManager()->assign(RbacFactory::Role($roles['admin']), $Account->id);

            $this->stdout("User have been successfully added\n", Console::FG_GREEN);
        } else {
            $this->stdout("ERROR creating user\n", Console::FG_RED);

            $error = array_shift($Account->getFirstErrors());
            if (!empty($error)) {
                $this->stdout("\t> {$error}\n", Console::FG_RED);
            }

            return static::EXIT_CODE_ERROR;
        }

        return static::EXIT_CODE_NORMAL;
    }
}
