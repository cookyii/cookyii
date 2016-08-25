<?php
/**
 * AbstractDriver.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\backup\drivers;

use yii\helpers\FileHelper;

/**
 * Class AbstractDriver
 * @package cookyii\backup\drivers
 */
abstract class AbstractDriver extends \yii\base\Object implements DriverInterface
{

    /**
     * @var \cookyii\backup\Controller
     */
    public $controller;

    /**
     * @return string
     * @throws \yii\console\Exception
     */
    protected function prepareDump()
    {
        $path = implode(DIRECTORY_SEPARATOR, [
            \Yii::getAlias($this->controller->backupPath, false),
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
            throw new \yii\console\Exception('Backup path is not readable.');
        }

        if (!is_writable($path)) {
            throw new \yii\console\Exception('Backup path is not writable.');
        }

        return $path;
    }

    /**
     * @return string
     * @throws \yii\console\Exception
     */
    protected function prepareRestore()
    {

        return $path;
    }
}
