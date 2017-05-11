<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace cookyii\console\controllers;

/**
 * Class MigrateController
 * @package cookyii\console\controllers
 */
class MigrateController extends \yii\console\controllers\MigrateController
{

    /**
     * @var array
     */
    public $migrationsPath = [];

    /**
     * @var array
     */
    public $migrationConfig = [
        'charset'    => 'utf8mb4',
        'collate'    => 'utf8mb4_unicode_ci',
        'engine'     => 'InnoDB',
        'row-format' => 'COMPACT',
    ];

    /**
     * Creates a new migration instance.
     * @param string $class the migration class name
     * @return \yii\db\MigrationInterface the migration instance
     */
    protected function createMigration($class)
    {
        $extensions = \Yii::$app->extensions;
        if (!empty($extensions)) {
            foreach ($extensions as $name => $conf) {
                if (isset($conf['alias']) && !empty($conf['alias'])) {
                    foreach ($conf['alias'] as $alias => $path) {
                        $file = $path . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . $class . '.php';

                        if (file_exists($file)) {
                            require_once($file);

                            return $this->createMigrationInstance($class);
                        }
                    }
                }
            }
        }

        if (!empty($this->migrationsPath)) {
            foreach ($this->migrationsPath as $path) {
                $path = \Yii::getAlias($path, false);
                if (!empty($path)) {
                    $file = $path . DIRECTORY_SEPARATOR . $class . '.php';

                    if (file_exists($file)) {
                        require_once($file);

                        return $this->createMigrationInstance($class);
                    }
                }
            }
        }

        $file = $this->migrationPath . DIRECTORY_SEPARATOR . $class . '.php';
        if (file_exists($file)) {
            require_once($file);

            return $this->createMigrationInstance($class);
        }

        throw new \RuntimeException(sprintf('Could not find the migration `%s`', $class));
    }

    /**
     * @param string $class
     * @return \yii\db\MigrationInterface
     */
    protected function createMigrationInstance($class)
    {
        $Migration = new $class;

        $Migration->db = $this->db;

        return $Migration;
    }

    /**
     * Returns the migrations that are not applied.
     * @return array list of new migrations
     */
    protected function getNewMigrations()
    {
        $applied = [];
        foreach ($this->getMigrationHistory(null) as $version => $time) {
            $applied[substr($version, 1, 13)] = true;
        }

        $migrations = [];

        $extensions = \Yii::$app->extensions;
        if (!empty($extensions)) {
            foreach ($extensions as $name => $conf) {
                if (isset($conf['alias']) && !empty($conf['alias'])) {
                    foreach ($conf['alias'] as $alias => $path) {
                        $path = $path . DIRECTORY_SEPARATOR . 'migrations';

                        $this->scanDirectory($path, $applied, $migrations);
                    }
                }
            }
        }

        if (!empty($this->migrationsPath)) {
            foreach ($this->migrationsPath as $path) {
                $path = \Yii::getAlias($path, false);

                if (!empty($path)) {
                    $this->scanDirectory($path, $applied, $migrations);
                }
            }
        }

        $this->scanDirectory($this->migrationPath, $applied, $migrations);

        sort($migrations);

        return $migrations;
    }

    /**
     * @param string $path
     * @param array $applied
     * @param array $migrations
     */
    protected function scanDirectory($path, $applied, &$migrations)
    {
        if (!file_exists($path) || !is_dir($path) || !is_readable($path)) {
            return;
        }

        $handle = opendir($path);

        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            if (preg_match('/^(m(\d{6}_\d{6})_.*?)\.php$/', $file, $matches)) {
                $a = !isset($applied[$matches[2]]);
                $b = is_file($path . DIRECTORY_SEPARATOR . $file);
                $c = !in_array($matches[1], $migrations, true);

                if ($a && $b && $c) {
                    $migrations[] = $matches[1];
                }
            }
        }

        closedir($handle);
    }
}
