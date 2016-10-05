<?php
/**
 * Mysql.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\backup\drivers;

/**
 * Class Mysql
 * @package cookyii\backup\drivers
 */
class Mysql extends AbstractDriver implements DriverInterface
{

    /**
     * @return string
     */
    public function dumpSchema()
    {
        $time = microtime(true);

        $path = $this->prepareDump();

        $resultFile = $path . DIRECTORY_SEPARATOR . 'schema.sql';

        $dumpKeys = $this->controller->dumpKeys;

        $excludeTablesSchema = $this->controller->excludeTablesSchema;

        if (!empty($excludeTablesSchema)) {
            $database = $this->controller->credentials['database'];
            $tables = $excludeTablesSchema;

            foreach ($tables as $table) {
                $dumpKeys[] = "--ignore-table={$database}.{$table}";
            }
        }

        $cmd = sprintf(
            ' mysqldump --defaults-extra-file=%s --no-data %s %s -v > %s',
            $this->controller->getCredentialsFile(),
            implode(' ', $dumpKeys),
            $this->controller->credentials['database'],
            $resultFile
        );

        $this->controller->stdout("    > EXECUTE ----------------------\n");
        $this->controller->stdout($cmd . "\n");
        $this->controller->stdout("    > ------------------------------\n");

        passthru($cmd);

        $time = sprintf('%.3f', microtime(true) - $time);

        $this->controller->stdout("    > END (time: {$time}s) ---------------\n");

        return $resultFile;
    }

    /**
     * @return string
     */
    public function dumpData()
    {
        $time = microtime(true);

        $path = $this->prepareDump();

        $resultFile = $path . DIRECTORY_SEPARATOR . 'data.sql';

        $dumpKeys = $this->controller->dumpKeys;

        $excludeTablesData = $this->controller->excludeTablesData;

        if (!empty($excludeTablesData)) {
            $database = $this->controller->credentials['database'];
            $tables = $excludeTablesData;

            foreach ($tables as $table) {
                $dumpKeys[] = "--ignore-table={$database}.{$table}";
            }
        }

        $cmd = sprintf(
            'mysqldump --defaults-extra-file=%s --no-create-info %s %s -v > %s',
            $this->controller->getCredentialsFile(),
            implode(' ', $dumpKeys),
            $this->controller->credentials['database'],
            $resultFile
        );

        $this->controller->stdout("    > EXECUTE ----------------------\n");
        $this->controller->stdout($cmd . "\n");
        $this->controller->stdout("    > ------------------------------\n");

        passthru($cmd);

        $time = sprintf('%.3f', microtime(true) - $time);

        $this->controller->stdout("    > END (time: {$time}s) ---------------\n");

        return $resultFile;
    }

    /**
     * @param string $variant
     */
    public function restoreDump($variant)
    {
        $time = strtotime($variant);
        $date = Formatter()->asDatetime($time, 'dd MMM yyyy HH:mm');

        $this->controller->stdout("    > Selected backup $date.\n");

        $path = implode(DIRECTORY_SEPARATOR, [
            \Yii::getAlias($this->controller->backupPath, false),
            str_replace(' ', DIRECTORY_SEPARATOR, $variant),
        ]);

        $schema = $path . DIRECTORY_SEPARATOR . 'schema.sql';
        $schemaConfirm = false;

        if (!file_exists($schema)) {
            $this->controller->stdout("      > Schema dump not found.\n");
        } elseif (!is_readable($schema)) {
            $this->controller->stdout("      > Schema dump not readable.\n");
        } else {
            $schemaConfirm = $this->controller->confirm('      > Do you want restore schema?');

            if (!$schemaConfirm) {
                $this->controller->stdout("        > Schema dump skipped.\n");
            }
        }

        $data = $path . DIRECTORY_SEPARATOR . 'data.sql';
        $dataConfirm = false;

        if (!file_exists($data)) {
            $this->controller->stdout("      > Data dump not found.\n");
        } elseif (!is_readable($data)) {
            $this->controller->stdout("      > Data dump not readable.\n");
        } else {
            $dataConfirm = $this->controller->confirm('      > Do you want restore data?');

            if (!$dataConfirm) {
                $this->controller->stdout("        > Data dump skipped.\n");
            }
        }

        if ($schemaConfirm) {
            $this->controller->stdout("        > Restoring schema... ");

            $time = microtime(true);

            $cmd = sprintf(
                'mysql --defaults-extra-file=%s %s %s < %s',
                $this->controller->getCredentialsFile(),
                implode(' ', $this->controller->restoreKeys),
                $this->controller->credentials['database'],
                $schema
            );

            $this->controller->stdout("    > REST SCHEMA ------------------\n");
            $this->controller->stdout($cmd . "\n");
            $this->controller->stdout("    > ------------------------------\n");

            passthru($cmd);

            $time = sprintf('%.3f', microtime(true) - $time);

            $this->controller->stdout("    > END (time: {$time}s) ---------------\n");
        }

        if ($dataConfirm) {
            $this->controller->stdout("        > Restoring data... ");

            $time = microtime(true);

            $cmd = sprintf(
                'mysql --defaults-extra-file=%s %s %s < %s',
                $this->controller->getCredentialsFile(),
                implode(' ', $this->controller->restoreKeys),
                $this->controller->credentials['database'],
                $data
            );

            $this->controller->stdout("    > REST DATA --------------------\n");
            $this->controller->stdout($cmd . "\n");
            $this->controller->stdout("    > ------------------------------\n");

            passthru($cmd);

            $time = sprintf('%.3f', microtime(true) - $time);

            $this->controller->stdout("    > END (time: {$time}s) ---------------\n");
        }
    }
}
