<?php
/**
 * AbstractResource.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Media\media;

use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\StringHelper;

/**
 * Class AbstractResource
 * @package cookyii\modules\Media\media
 */
abstract class AbstractResource extends \yii\base\Object implements ResourceInterface
{

    /**
     * @var string
     */
    public static $mediaModule = 'media';

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        $source = ArrayHelper::remove($config, 'source');

        parent::__construct($config);

        if (!empty($source)) {
            $this->setSource($source);
        }
    }

    /**
     * @param mixed $source
     * @param array $options
     * @return static
     */
    public static function create($source, $options = [])
    {
        $options['source'] = $source;

        return new static($options);
    }

    /**
     * @return bool
     */
    public function isImage()
    {
        return $this->getImageSize() !== false;
    }

    /**
     * @return bool
     */
    public function getImageSize()
    {
        return @getimagesize($this->getTemp());
    }

    /**
     * @return string
     */
    public function getSha1()
    {
        return sha1_file($this->getTemp());
    }

    /**
     * @return string|false
     */
    public function moveToUpload()
    {
        $filename = sha1(microtime());
        $ext = pathinfo($this->getName(), PATHINFO_EXTENSION);

        $upload_path = $this->getMediaModule()->uploadPath;
        $p1 = StringHelper::byteSubstr($filename, 0, 2);
        $p2 = StringHelper::byteSubstr($filename, 2, 2);
        $path = $upload_path . DIRECTORY_SEPARATOR . $p1 . DIRECTORY_SEPARATOR . $p2;
        if (!file_exists($path)) {
            FileHelper::createDirectory($path);
        }

        $file_path = $path . DIRECTORY_SEPARATOR . $filename . '.' . $ext;

        $result = copy($this->getTemp(), $file_path);
        $this->clear();

        chmod($file_path, 0664);

        return $result === true ? $file_path : false;
    }

    public function clear()
    {
        unlink($this->getTemp());
    }

    /**
     * @return \cookyii\modules\Media\Module
     */
    public static function getMediaModule()
    {
        /** @var \cookyii\modules\Media\Module|null $Module */
        $Module = \Yii::$app->getModule(static::$mediaModule);

        if (!($Module instanceof \cookyii\modules\Media\Module)) {
            throw new \RuntimeException(\Yii::t('cookyii.media', 'Media module not configured'));
        }

        return $Module;
    }
}