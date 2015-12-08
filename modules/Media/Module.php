<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Media;

use yii\helpers\FileHelper;

/**
 * Class Module
 * @package cookyii\modules\Media
 */
class Module extends \yii\base\Module
{

    /** @var string */
    public $moduleName = 'media';

    /** @var string */
    public $uploadPath = '@upload';

    /** @var string */
    public $uploadWebPath = '/upload';

    /** @var string */
    public $storagePath = '@upload/storage';

    /** @var string */
    public $storageWebPath = '/upload/storage';

    /** @var int */
    public $maxUploadFileSize = 10; // megabytes

    /** @var string */
    public $placeholderAlias = '@app/web/img/placeholder.png';

    /** @var int */
    public $pathChmod = 0775;

    /** @var int */
    public $fileChmod = 0664;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ((int)ini_get('upload_max_filesize') < $this->maxUploadFileSize) {
            \Yii::warning(
                sprintf('The parameter `%s` in php.ini must be equal to`%s`', 'upload_max_filesize', $this->maxUploadFileSize . 'M'),
                __METHOD__
            );
        }

        if ((int)ini_get('post_max_size') < $this->maxUploadFileSize) {
            \Yii::warning(
                sprintf('The parameter `%s` in php.ini must be equal to`%s`', 'post_max_size', $this->maxUploadFileSize . 'M'),
                __METHOD__
            );
        }

        $this->uploadWebPath = \Yii::getAlias($this->uploadWebPath);
        $this->uploadPath = \Yii::getAlias($this->uploadPath);
        $this->storageWebPath = \Yii::getAlias($this->storageWebPath);
        $this->storagePath = \Yii::getAlias($this->storagePath);

        if (empty($this->uploadPath)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('cookyii.media', 'Unable to determine the path to the upload directory (Media::$uploadPath).'));
        }

        if (empty($this->storagePath)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('cookyii.media', 'Unable to determine the path to the storage directory (Media::$storagePath).'));
        }

        if (!file_exists($this->uploadPath) || !is_dir($this->uploadPath)) {
            FileHelper::createDirectory($this->uploadPath);
        }

        if (!file_exists($this->storagePath) || !is_dir($this->storagePath)) {
            FileHelper::createDirectory($this->storagePath);
        }

        if (!is_readable($this->uploadPath)) {
            throw new \RuntimeException(\Yii::t('cookyii.media', 'Upload directory not available for reading (Media::$uploadPath).'));
        }

        if (!is_writable($this->uploadPath)) {
            throw new \RuntimeException(\Yii::t('cookyii.media', 'Upload directory not available for writing (Media::$uploadPath).'));
        }

        if (!is_readable($this->storagePath)) {
            throw new \RuntimeException(\Yii::t('cookyii.media', 'Storage directory not available for reading (Media::$storagePath).'));
        }

        if (!is_writable($this->storagePath)) {
            throw new \RuntimeException(\Yii::t('cookyii.media', 'Storage directory not available for writing (Media::$storagePath).'));
        }
    }
}