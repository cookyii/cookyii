<?php
/**
 * UserCommand.php
 * @author Revin Roman
 */

namespace cookyii\modules\Account\commands;

use rmrevin\yii\rbac\RbacFactory;

/**
 * Class UserCommand
 * @package cookyii\modules\Account\commands
 */
class UserCommand extends \yii\console\Controller
{

    /**
     * @param string $email
     * @param string $name
     * @param string $pass
     * @return int
     */
    public function actionAdd($email = '', $name = '', $pass = '')
    {
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

        $User = new \resources\Account([
            'name' => $name,
            'email' => $email,
            'password' => $pass,
            'activated' => \resources\Account::ACTIVATED,
            'deleted' => \resources\Account::NOT_DELETED,
        ]);

        $User->save();
        if (!$User->hasErrors()) {
            AuthManager()->assign(RbacFactory::Role(\common\Roles::USER), $User->id);
            AuthManager()->assign(RbacFactory::Role(\common\Roles::ADMIN), $User->id);

            $this->stdout("User have been successfully added\n", \yii\helpers\Console::FG_GREEN);
        } else {
            $this->stdout("ERROR creating user\n", \yii\helpers\Console::FG_RED);

            $error = array_shift($User->getFirstErrors());
            if (!empty($error)) {
                $this->stdout("\t> {$error}\n", \yii\helpers\Console::FG_RED);
            }

            return static::EXIT_CODE_ERROR;
        }

        return static::EXIT_CODE_NORMAL;
    }
}