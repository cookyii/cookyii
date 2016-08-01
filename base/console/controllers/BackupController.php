<?php
/**
 * BackupController.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\console\controllers;

use yii\db\Connection;
use yii\di\Instance;
use yii\helpers\FileHelper;

/**
 * Class BackupController
 * @package cookyii\console\controllers
 */
class BackupController extends \yii\console\Controller
{

    /**
     * @var array
     */
    public $credentials = [
        'host' => null,
        'user' => null,
        'password' => null,
        'database' => null,
    ];

    /**
     * @var string
     */
    public $backupPath = '@base/.backups';

    /**
     * @var array
     */
    public $dumpKeys = [
        '--add-drop-table',
        '--add-drop-trigger',
        '--add-locks',
        '--disable-keys',
        '--compress',
        '--extended-insert',
        '--triggers',
        '--replace',
    ];

    /**
     * @var array
     */
    public $restoreKeys = [
        '--compress',
    ];

    /**
     * @var array
     */
    public $ignoreTables = [];

    /**
     * @var Connection|array|string
     */
    public $db = 'db';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->db = Instance::ensure($this->db, Connection::className());

        $this->prepareCredentials();
    }

    /**
     * Prepare credentials
     */
    protected function prepareCredentials()
    {
        $credentials = $this->credentials;

        $credentials['host'] = empty($credentials['host']) && defined('DB_HOST')
            ? constant('DB_HOST')
            : $credentials['host'];

        $credentials['user'] = empty($credentials['user']) && defined('DB_USER')
            ? constant('DB_USER')
            : $credentials['user'];

        $credentials['password'] = empty($credentials['password']) && defined('DB_PASS')
            ? constant('DB_PASS')
            : $credentials['password'];

        $credentials['database'] = empty($credentials['database']) && defined('DB_BASE')
            ? constant('DB_BASE')
            : $credentials['database'];

        $this->credentials = $credentials;
    }

    /**
     * @return int
     * @throws \yii\base\Exception
     */
    public function actionDump()
    {
        switch ($this->db->driverName) {
            case 'mysql':
                $this->dumpMysql();
                break;
            default:
                throw new \yii\base\Exception('Unsupported database schema');
                break;
        }

        return MigrateController::EXIT_CODE_NORMAL;
    }

    /**
     * @return int
     * @throws \yii\base\Exception
     */
    public function actionRestore()
    {
        switch ($this->db->driverName) {
            case 'mysql':
                $this->restoreMysql();
                break;
            default:
                throw new \yii\base\Exception('Unsupported database schema');
                break;
        }

        return MigrateController::EXIT_CODE_NORMAL;
    }

    /**
     * Dump mysql scenario
     * @throws \yii\console\Exception
     */
    protected function dumpMysql()
    {
        $this->stdout("Begin dumping database...\n");

        $time = microtime(true);

        $path = implode(DIRECTORY_SEPARATOR, [
            \Yii::getAlias($this->backupPath, false),
            Formatter()->asDate(time(), 'yyyy-MM-dd'),
            Formatter()->asTime(time(), 'HH:mm:ss'),
        ]);

        if (!file_exists($path)) {
            FileHelper::createDirectory($path);
        }

        if (!file_exists($path) || !is_dir($path)) {
            throw new \yii\console\Exception('Backup path not found.');
        }

        if (!is_readable($path)) {
            throw new \yii\console\Exception('Backup path not readable.');
        }

        if (!is_writable($path)) {
            throw new \yii\console\Exception('Backup path not writable.');
        }

        $schema_fullPath = $path . DIRECTORY_SEPARATOR . 'schema.sql';

        $dumpKeys = $this->dumpKeys;

        if (!empty($this->ignoreTables)) {
            $database = $this->credentials['database'];
            $ignoreTables = $this->ignoreTables;

            foreach ($ignoreTables as $table) {
                $dumpKeys[] = "--ignore-table={$database}.{$table}";
            }
        }

        $cmd = sprintf(
            ' mysqldump --defaults-extra-file=%s --no-data %s %s -v > %s',
            $this->getCredentialsFile(),
            implode(' ', $dumpKeys),
            $this->credentials['database'],
            $schema_fullPath
        );

        passthru($cmd);

        $data_fullPath = $path . DIRECTORY_SEPARATOR . 'data.sql';

        $cmd = sprintf(
            ' mysqldump --defaults-extra-file=%s --no-create-info %s %s -v > %s',
            $this->getCredentialsFile(),
            implode(' ', $dumpKeys),
            $this->credentials['database'],
            $data_fullPath
        );

        passthru($cmd);

        $time = sprintf('%.3f', microtime(true) - $time);

        $this->stdout("\n");
        $this->stdout("-------------------------\n");
        $this->stdout("\n");
        $this->stdout("New backup  done (time: {$time}s).\n");
        $this->stdout("$schema_fullPath\n");
        $this->stdout("$data_fullPath\n");
    }

    /**
     * Restore mysql scenario
     * @throws \yii\console\Exception
     */
    protected function restoreMysql()
    {
        $this->stdout('Search backups... ');

        $path = \Yii::getAlias($this->backupPath, false);

        if (!file_exists($path)) {
            FileHelper::createDirectory($path);
        }

        if (!file_exists($path) || !is_dir($path)) {
            throw new \yii\console\Exception('Backup path not found.');
        }

        if (!is_readable($path)) {
            throw new \yii\console\Exception('Backup path not readable.');
        }

        $dh = opendir($path);
        if (!is_resource($dh)) {
            throw new \yii\console\Exception("Failed to open backup path $path.");
        } else {
            $sections = [];

            while (($file = readdir($dh)) !== false) {
                if (in_array($file, ['.', '..'], true) || !is_dir($path . DIRECTORY_SEPARATOR . $file)) {
                    continue;
                }

                $sections[] = $file;
            }

            closedir($dh);

            if (empty($sections)) {
                $this->stdout("not found.\n");
            } else {
                usort($sections, function ($a, $b) {
                    $a = strtotime($a);
                    $b = strtotime($b);

                    return ($a > $b) ? -1 : 1;
                });

                $backups = [];

                foreach ($sections as $section) {
                    $p = $path . DIRECTORY_SEPARATOR . $section;
                    $dh = opendir($p);

                    if (!is_resource($dh)) {
                        throw new \yii\console\Exception("Failed to open backup path $p.");
                    } else {
                        while (($file = readdir($dh)) !== false) {
                            if (in_array($file, ['.', '..'], true)) {
                                continue;
                            }

                            $backups[] = $section . ' ' . $file;
                        }

                        closedir($dh);
                    }
                }

                if (empty($backups)) {
                    $this->stdout("not found.\n");
                } else {
                    usort($backups, function ($a, $b) {
                        $a = strtotime($a);
                        $b = strtotime($b);

                        return ($a > $b) ? -1 : 1;
                    });

                    $total = count($backups);

                    $this->stdout("found $total backups.\n");
                    $this->stdout("\n");

                    $this->selectBackup($backups);
                }
            }
        }
    }

    /**
     * @param array $backups
     * @param int $offset
     * @param int $limit
     */
    protected function selectBackup(array $backups, $offset = 0, $limit = 8)
    {
        $total = count($backups);

        $current_backups = [];

        if ($offset > 0) {
            $current_backups[1] = 'Show prev backups';
        } else {
            $current_backups[1] = '----';
        }

        $slice = array_slice($backups, $offset, $limit);

        if (!empty($slice)) {
            foreach ($slice as $row) {
                $current_backups[] = $row;
            }
        }

        if ((count($current_backups) + $offset) < $total) {
            $current_backups[0] = 'Show next backups';
        } else {
            $current_backups[0] = '----';
        }

        foreach ($current_backups as $key => $variant) {
            $time = strtotime($variant);

            if ($time) {
                $date = Formatter()->asDatetime($time, 'dd MMM yyyy HH:mm');

                $this->stdout("    $key => $date\n");
            } else {
                $this->stdout("    $key => $variant\n");
            }
        }

        $this->stdout("\n");

        $res = $this->select('Select backup to restore', $current_backups);

        $variant = $current_backups[$res];

        if ($variant === 'Show prev backups') {
            $this->stdout("\n");
            $this->selectBackup($backups, $offset - $limit, $limit);
        } elseif ($variant === 'Show next backups') {
            $this->stdout("\n");
            $this->selectBackup($backups, $offset + $limit, $limit);
        } elseif ($variant === '----') {
            $this->stdout("Exit.\n");
        } else {
            $this->stdout("\n");
            $this->doRestore($variant);
        }
    }

    /**
     * @param string $variant
     */
    protected function doRestore($variant)
    {
        $time = strtotime($variant);
        $date = Formatter()->asDatetime($time, 'dd MMM yyyy HH:mm');

        $this->stdout("    > Selected backup $date.\n");

        $path = implode(DIRECTORY_SEPARATOR, [
            \Yii::getAlias($this->backupPath, false),
            str_replace(' ', DIRECTORY_SEPARATOR, $variant),
        ]);

        $schema = $path . DIRECTORY_SEPARATOR . 'schema.sql';
        $schemaConfirm = false;

        if (!file_exists($schema)) {
            $this->stdout("      > Schema dump not found.\n");
        } elseif (!is_readable($schema)) {
            $this->stdout("      > Schema dump not readable.\n");
        } else {
            $schemaConfirm = $this->confirm('      > Do you want restore schema?');

            if (!$schemaConfirm) {
                $this->stdout("        > Schema dump skipped.\n");
            }
        }

        $data = $path . DIRECTORY_SEPARATOR . 'data.sql';
        $dataConfirm = false;

        if (!file_exists($data)) {
            $this->stdout("      > Data dump not found.\n");
        } elseif (!is_readable($data)) {
            $this->stdout("      > Data dump not readable.\n");
        } else {
            $dataConfirm = $this->confirm('      > Do you want restore data?');

            if (!$dataConfirm) {
                $this->stdout("        > Data dump skipped.\n");
            }
        }

        if ($schemaConfirm) {
            $this->stdout("        > Restoring schema... ");

            $time = microtime(true);

            $cmd = sprintf(
                ' mysql --defaults-extra-file=%s %s %s < %s',
                $this->getCredentialsFile(),
                implode(' ', $this->restoreKeys),
                $this->credentials['database'],
                $schema
            );

            passthru($cmd);

            $time = sprintf('%.3f', microtime(true) - $time);

            $this->stdout("done (time: {$time}s).\n");
        }

        if ($dataConfirm) {
            $this->stdout("        > Restoring data... ");

            $time = microtime(true);

            $cmd = sprintf(
                ' mysql --defaults-extra-file=%s %s %s < %s',
                $this->getCredentialsFile(),
                implode(' ', $this->restoreKeys),
                $this->credentials['database'],
                $data
            );

            passthru($cmd);

            $time = sprintf('%.3f', microtime(true) - $time);

            $this->stdout("done (time: {$time}s).\n");
        }
    }

    /**
     * @return bool|string
     */
    protected function getCredentialsFile()
    {
        $path = \Yii::getAlias('@runtime/credentials.conf');

        if (!file_exists($path)) {
            $data = implode("\n", [
                '[client]',
                'host=' . $this->credentials['host'],
                'user=' . $this->credentials['user'],
                'password=' . $this->credentials['password'],
            ]);

            file_put_contents($path, $data);
        }

        return $path;
    }

    /**
     * Destruct
     */
    public function __destruct()
    {
        $file = $this->getCredentialsFile();

        @unlink($file);
    }
}
