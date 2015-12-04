<?php
/**
 * ExtractTask.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace dev\build;

use cookyii\build\tasks\CallableTask;

/**
 * Class InstallTask
 * @package dev\build
 */
class InstallTask extends CallableTask
{

    /** @var string */
    public $envDistFile = '.env.dist.php';

    /** @var string */
    public $envFile = '.env.php';

    /** @var string */
    public $mysqlHost = 'localhost';

    /** @var string */
    public $mysqlPort = 3306;

    /** @var string */
    public $mysqlSocket;

    /** @var string|array required */
    public $database;

    /** @var string */
    public $mysqlUserHost = 'localhost';

    /** @var string required */
    public $mysqlUserName;

    /** @var string|null */
    public $mysqlUserPassword;

    /** @var string */
    public $mysqlRootPassword;

    /** @var string */
    public $domain;

    /** @var \mysqli */
    protected $connect;

    public function init()
    {
        parent::init();

        $this->handler = function () {
            if ($this->checkProperties()) {
                $this->askMysqlRootPassword();
                $this->createDatabases();

                $this->askDomain();
                $this->copyEnvironmentConfig();

                return true;
            }

            return false;
        };
    }

    public function __destruct()
    {
        if ($this->connect instanceof \mysqli) {
            mysqli_close($this->connect);
        }
    }

    /**
     * @return \Symfony\Component\Console\Helper\DialogHelper
     */
    protected function dialog()
    {
        return $this->command->getHelper('dialog');
    }

    /**
     * @return bool
     */
    protected function checkProperties()
    {
        $stop = false;
        if (empty($this->envDistFile)) {
            $stop = true;
            $this->log('<task-error> ERR </task-error> Empty path to distribution environment config (in build.php `install/.task/envDistFile`).');
        }

        if (empty($this->envFile)) {
            $stop = true;
            $this->log('<task-error> ERR </task-error> Empty path to environment config (in build.php `install/.task/envFile`).');
        }

        if (empty($this->mysqlUserName)) {
            $stop = true;
            $this->log('<task-error> ERR </task-error> Empty mysql username for new database (in build.php `install/.task/mysqlUserName`).');
        }

        if (empty($this->database)) {
            $stop = true;
            $this->log('<task-error> ERR </task-error> Empty install database list (in build.php `install/.task/database`).');
        }

        $envFile = $this->getAbsolutePath($this->envFile);
        if (file_exists($envFile)) {
            $this->log('<comment> ASK </comment> Environment config already initialized.');
            $res = $this->dialog()->askConfirmation($this->output, '        Do you want to reset it? [y/N] ', false);
            if (!$res) {
                $stop = true;
                $this->log('<task-result> STOP </task-result> The installation process was interrupted.');
            }
        }

        return !$stop;
    }

    /**
     * @param bool $force
     */
    protected function askDomain($force = false)
    {
        if ($force || empty($this->domain)) {
            $this->log('<question> ASK </question> Enter domain name:', 0, false);
            $this->domain = $this->dialog()
                ->ask($this->output, ' ');

            if (empty($this->domain)) {
                $this->askDomain($force);
            }
        }
    }

    /**
     * @param bool $force
     */
    protected function askMysqlRootPassword($force = false)
    {
        if ($force || empty($this->mysqlRootPassword)) {
            $this->log('<question> ASK </question> Enter mysql root password (input hidden):', 0, false);
            $this->mysqlRootPassword = $this->dialog()
                ->askHiddenResponse($this->output, ' ');
        }
    }

    protected function copyEnvironmentConfig()
    {
        $result = false;

        $replace = [
            '<domain>' => $this->domain,
            '<cookoe-validation-key>' => $this->generateRandomString(),
            '<mysql-user-host>' => $this->mysqlUserHost,
            '<mysql-user-name>' => $this->mysqlUserName,
            '<mysql-user-password>' => $this->mysqlUserPassword,
        ];

        foreach ((array)$this->database as $k => $database) {
            $replace[sprintf('<mysql-base-%s>', $k)] = $database;
        }

        $envDistFile = $this->getAbsolutePath($this->envDistFile);
        $envFile = $this->getAbsolutePath($this->envFile);
        $envFilePath = dirname($envFile);

        $allRight = true;
        if (!is_readable($envDistFile)) {
            $allRight = false;
            $this->log('<task-error> ERR </task-error> Distribution environment config is not readable.');
        }

        if ((file_exists($envFile) && !is_writable($envFile)) || !is_writable($envFilePath)) {
            $allRight = false;
            $this->log(sprintf('<task-error> ERR </task-error> Environment config path is not writable (%s).', $envFilePath));
        }

        if ($allRight) {
            $content = file_get_contents($envDistFile);
            $content = str_replace(array_keys($replace), array_values($replace), $content);

            $result = file_put_contents($envFile, $content);

            if ($result) {
                $this->log(sprintf('<task-result> ENV </task-result> Environment config initialized.', $database));
            }
        }

        return $result;
    }

    /**
     * @param string $charset
     * @param string $collate
     * @return bool
     */
    protected function createDatabases($charset = 'utf8', $collate = 'utf8_unicode_ci')
    {
        $result = false;

        $this->connect = @mysqli_connect($this->mysqlHost, 'root', $this->mysqlRootPassword, null, $this->mysqlPort, $this->mysqlSocket);

        if ($err = mysqli_connect_error()) {
            $this->log(sprintf('<task-error> ERR </task-error> Can\'t connect to mysql (%s).', $err));
        } else {
            foreach ((array)$this->database as $database) {
                $sql = sprintf(
                    'CREATE SCHEMA `%s` DEFAULT CHARACTER SET %s COLLATE %s;',
                    $database,
                    $charset,
                    $collate
                );

                $created = false;
                if (mysqli_query($this->connect, $sql)) {
                    $this->log(sprintf('<task-result> DB  </task-result> Database `%s` created.', $database));
                    $created = true;
                } else {
                    $errno = mysqli_errno($this->connect);
                    $error = mysqli_error($this->connect);
                    $this->log(sprintf('<task-error> ERR </task-error> %s.', $error));
                    if ($errno === 1007) {
                        $created = true;
                    }
                }

                if ($created) {
                    if ($this->createDatabaseUser($database, $this->mysqlUserName, $this->mysqlUserHost, $this->mysqlUserPassword)) {
                        $this->log(sprintf('<task-result> DB  </task-result> User `%s` assigned for db `%s`.', $this->mysqlUserName, $database));
                    }
                }

                $result = true;
            }
        }

        return $result;
    }

    protected function createDatabaseUser($database, $name, $host = 'localhost', $password = null)
    {
        if (empty($password)) {
            $password = $this->mysqlUserPassword = substr($this->generateRandomString(), 0, 12);
        }

        $sql = sprintf(
            'SELECT COUNT(*) as `count` FROM `mysql`.`user` WHERE `User` = \'%s\' AND `Host` = \'%s\'',
            $name,
            $host
        );

        $res = mysqli_query($this->connect, $sql);
        $data = mysqli_fetch_assoc($res);
        $exists = false;
        if ($data['count'] <= 0) {
            $sql = sprintf(
                'CREATE USER \'%s\'@\'%s\' IDENTIFIED BY \'%s\';',
                $name,
                $host,
                $password
            );

            if (mysqli_query($this->connect, $sql)) {
                $this->log(sprintf('<task-result> DB  </task-result> User `%s` created. <task-error> PASS   %s </task-error>', $name, $password));

                $exists = true;
            } else {
                $errno = mysqli_errno($this->connect);
                $error = mysqli_error($this->connect);
                $this->log(sprintf('<task-error> ERR </task-error> %s.', $error));
            }
        } else {
            $exists = true;
        }

        if ($exists) {
            $sql = sprintf(
                'GRANT ALL PRIVILEGES ON `%s`.* TO \'%s\'@\'%s\';',
                $database,
                $name,
                $host
            );

            return mysqli_query($this->connect, $sql);
        }

        return false;
    }

    protected function generateRandomString()
    {
        return sha1(uniqid(time()));
    }
}