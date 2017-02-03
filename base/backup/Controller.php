<?php
/**
 * Controller.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\backup;

use cookyii\Facade as F;
use yii\db\Connection;
use yii\di\Instance;
use yii\helpers\FileHelper;

/**
 * Class Controller
 * @package cookyii\backup
 */
class Controller extends \yii\console\Controller
{

    /**
     * @var string|null
     */
    public $db_driver;

    /**
     * @var Connection|array|string
     */
    public $db = 'db';

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
        '--complete-insert',
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
     * Exclude this tables from schema dump
     * @var array
     */
    public $excludeTablesSchema = [];

    /**
     * Exclude this tables from data dump
     * @var array
     */
    public $excludeTablesData = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->db = Instance::ensure($this->db, Connection::class);

        if (empty($this->db_driver)) {
            $this->db_driver = $this->db->driverName;
        }

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
     * @return bool|string
     */
    public function getCredentialsFile()
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
     * @return int
     * @throws \yii\base\Exception
     */
    public function actionDump()
    {
        $this->stdout("Begin dumping database...\n");

        $time = microtime(true);

        switch ($this->db_driver) {
            case 'mysql':
                $Driver = new drivers\Mysql([
                    'controller' => $this,
                ]);
                break;
            default:
                throw new \yii\base\Exception('Unsupported database schema');
                break;
        }

        $schema = $Driver->dumpSchema();
        $data = $Driver->dumpData();

        $time = sprintf('%.3f', microtime(true) - $time);

        $this->stdout("\n");
        $this->stdout("-------------------------\n");
        $this->stdout("\n");
        $this->stdout("New backup  done (time: {$time}s).\n");
        $this->stdout("$schema\n");
        $this->stdout("$data\n");

        return static::EXIT_CODE_NORMAL;
    }

    /**
     * @return int
     * @throws \yii\base\Exception
     */
    public function actionRestore()
    {
        $this->stdout('Search backups... ');

        switch ($this->db_driver) {
            case 'mysql':
                $Driver = new drivers\Mysql([
                    'controller' => $this,
                ]);
                break;
            default:
                throw new \yii\base\Exception('Unsupported database schema');
                break;
        }

        $backups = $this->getBackupList();

        if (empty($backups)) {
            $this->stdout("not found.\n");
        } else {
            $variant = $this->showBackupsSelector($backups);

            if (empty($variant)) {
                throw new \yii\base\Exception('Backup not selected');
            } else {
                $Driver->restoreDump($variant);
            }
        }

        return static::EXIT_CODE_NORMAL;
    }

    /**
     * @return array
     * @throws \yii\console\Exception
     */
    protected function getBackupList()
    {
        $result = [];

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

                            $result[] = $section . ' ' . $file;
                        }

                        closedir($dh);
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @param array $backups
     * @return false|string
     * @throws \yii\base\Exception
     */
    protected function showBackupsSelector(array $backups)
    {
        usort($backups, function ($a, $b) {
            $a = strtotime($a);
            $b = strtotime($b);

            return ($a > $b) ? -1 : 1;
        });

        $total = count($backups);

        $this->stdout("found $total backups.\n");
        $this->stdout("\n");

        return $this->selectBackup($backups);
    }

    /**
     * @param array $backups
     * @param int $offset
     * @param int $limit
     * @return string|false
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
                $date = F::Formatter()->asDatetime($time, 'dd MMM yyyy HH:mm');

                $this->stdout("    $key => $date\n");
            } else {
                $this->stdout("    $key => $variant\n");
            }
        }

        $this->stdout("\n");

        $selected = $this->select('Select backup to restore', $current_backups);

        $variant = $current_backups[$selected];

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

            return $variant;
        }

        return false;
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
