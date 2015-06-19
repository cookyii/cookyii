<?php
/**
 * Module.php
 * @author Revin Roman
 */

namespace cookyii\modules\Media;

use yii\helpers\FileHelper;

/**
 * Class Module
 * @package cookyii\modules\Media
 */
class Module extends \yii\base\Module implements \yii\base\BootstrapInterface
{

    /** @var string */
    public $moduleName = 'media';

    /** @var string */
    public $uploadAlias = '@app/web/upload';

    /** @var string */
    public $uploadPath = null;

    /** @var string */
    public $uploadWebAlias = '/upload';

    /** @var string */
    public $uploadWebPath = null;

    /** @var string */
    public $storageAlias = '@app/web/storage';

    /** @var string */
    public $storagePath = null;

    /** @var string */
    public $storageWebAlias = '/storage';

    /** @var string */
    public $storageWebPath = null;

    /** @var int */
    public $maxUploadFileSize = 10; // megabytes

    public $placeholderAlias = '@common/_assets/_sources/img/placeholder.png';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->checkIniSizeParam('upload_max_filesize');

        $this->checkIniSizeParam('post_max_size');

        $this->initAliases();

        if (empty($this->uploadPath)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('media', 'Unable to determine the path to the upload directory (Media::$uploadPath).'));
        }

        if (empty($this->storagePath)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('media', 'Unable to determine the path to the storage directory (Media::$storagePath).'));
        }

        if (!file_exists($this->uploadPath) || !is_dir($this->uploadPath)) {
            FileHelper::createDirectory($this->uploadPath);
        }

        if (!file_exists($this->storagePath) || !is_dir($this->storagePath)) {
            FileHelper::createDirectory($this->storagePath);
        }

        if (!is_readable($this->uploadPath)) {
            throw new \RuntimeException(\Yii::t('media', 'Upload directory not available for reading (FileService::$uploadPath).'));
        }

        if (!is_writable($this->uploadPath)) {
            throw new \RuntimeException(\Yii::t('media', 'Upload directory not available for writing (FileService::$uploadPath).'));
        }

        if (!is_readable($this->storagePath)) {
            throw new \RuntimeException(\Yii::t('media', 'Storage directory not available for reading (FileService::$storagePath).'));
        }

        if (!is_writable($this->storagePath)) {
            throw new \RuntimeException(\Yii::t('media', 'Storage directory not available for writing (FileService::$storagePath).'));
        }
    }

    public function initAliases()
    {
        $this->storagePath = \Yii::getAlias($this->storageAlias);
        $this->storageWebPath = \Yii::getAlias($this->storageWebAlias);
        $this->uploadWebPath = \Yii::getAlias($this->uploadWebAlias);
        $this->uploadPath = \Yii::getAlias($this->uploadAlias);
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($APP)
    {
        $APP->getI18n()
            ->translations['media'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages',
        ];
    }

    /**
     * @param string $param
     */
    private function checkIniSizeParam($param)
    {
        if ((int)ini_get($param) < $this->maxUploadFileSize) {
            \Yii::warning(
                sprintf('The parameter `%s` in php.ini must be equal to`%s`', $param, $this->maxUploadFileSize . 'M'),
                __METHOD__
            );
        }
    }
}