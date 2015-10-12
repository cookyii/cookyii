<?php
/**
 * ImageWrapper.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Media;

use cookyii\modules\Media\components\Image;
use Imagine\Image\ImageInterface;
use Imagine\Image\ManipulatorInterface;
use yii\helpers\FileHelper;

/**
 * Class ImageWrapper
 * @package cookyii\modules\Media
 */
class ImageWrapper extends \yii\base\Object
{

    /** @var string */
    public static $mediaModule = 'media';

    /** @var \cookyii\modules\Media\resources\Media */
    public $Media = null;

    /** @var array */
    public $result = [null, null];

    /** @var array */
    protected $mark = [];

    /** @var array */
    protected $actions = [];

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->result[1];
    }

    /**
     * @return string
     */
    public function export()
    {
        $this->save();

        return (string)$this->result[1];
    }

    public function save()
    {
        $mark = sha1(serialize($this->mark));

        $this->result = [
            $this->getMarkedMediaPath($mark),
            $this->getMarkedMediaWebPath($mark),
        ];

        if (!file_exists($this->result[0])) {
            \Yii::trace(sprintf('create new file cache: ', $this->Media->id), __METHOD__);
            $this->createMarkedMedia($mark);
        } else {
            \Yii::trace(sprintf('file already cached: %s (%s)', $this->Media->id, serialize($this->mark)), __METHOD__);
        }

        \Yii::endProfile(sprintf('manipulating with file `%s`', $this->Media->id), 'Media\Manipulation');
    }

    /**
     * @param integer $width
     * @param integer $height
     * @param boolean $strict
     * @param string $filter
     * @return static
     */
    public function resize($width, $height, $strict = false, $filter = ImageInterface::FILTER_UNDEFINED)
    {
        \Yii::trace('resize file', __METHOD__);

        $this->mark(__METHOD__, func_get_args());
//        $this->save(function () use ($width, $height, $strict, $filter) {
//            return Image::resize($this->Media->getAbsolutePath(), $width, $height, $strict, $filter);
//        });
        $this->actions[] = function (&$Image) use ($width, $height, $strict, $filter) {
            return Image::resize($Image, $width, $height, $strict, $filter);
        };

        return $this;
    }

    /**
     * @param integer $width
     * @param boolean $strict
     * @param string $filter
     * @return static
     */
    public function resizeByWidth($width, $strict = false, $filter = ImageInterface::FILTER_UNDEFINED)
    {
        \Yii::trace('resizeByWidth file', __METHOD__);

        $this->mark(__METHOD__, func_get_args());
//        $this->save(function () use ($width, $strict, $filter) {
//            return Image::resizeByWidth($this->Media->getAbsolutePath(), $width, $strict, $filter);
//        });
        $this->actions[] = function (&$Image) use ($width, $strict, $filter) {
            return Image::resizeByWidth($Image, $width, $strict, $filter);
        };

        return $this;

    }

    /**
     * @param integer $height
     * @param boolean $strict
     * @param string $filter
     * @return static
     */
    public function resizeByHeight($height, $strict = false, $filter = ImageInterface::FILTER_UNDEFINED)
    {
        \Yii::trace('resizeByHeight file', __METHOD__);

        $this->mark(__METHOD__, func_get_args());
//        $this->save(function () use ($height, $strict, $filter) {
//            return Image::resizeByHeight($this->Media->getAbsolutePath(), $height, $strict, $filter);
//        });
        $this->actions[] = function (&$Image) use ($height, $strict, $filter) {
            return Image::resizeByHeight($Image, $height, $strict, $filter);
        };

        return $this;
    }

    /**
     * @param integer $width
     * @param integer $height
     * @param array $start
     * @return static
     */
    public function crop($width, $height, array $start = [0, 0])
    {
        \Yii::trace('crop file', __METHOD__);

        $this->mark(__METHOD__, func_get_args());
//        $this->save(function () use ($width, $height, $start) {
//            return Image::crop($this->Media->getAbsolutePath(), $width, $height, $start);
//        });
        $this->actions[] = function (&$Image) use ($width, $height, $start) {
            return Image::crop($Image, $width, $height, $start);
        };

        return $this;
    }

    /**
     * @param integer $width
     * @param integer $height
     * @param string $mode
     * @return static
     */
    public function thumbnail($width, $height, $mode = ManipulatorInterface::THUMBNAIL_OUTBOUND)
    {
        \Yii::trace('thumbnail file', __METHOD__);

        $this->mark(__METHOD__, func_get_args());
//        $this->save(function () use ($width, $height, $mode) {
//            return Image::thumbnail($this->Media->getAbsolutePath(), $width, $height, $mode);
//        });
        $this->actions[] = function (&$Image) use ($width, $height, $mode) {
            return Image::thumbnail($Image, $width, $height, $mode);
        };

        return $this;
    }

    /**
     * @param string $watermarkFilename
     * @param array $start
     * @return static
     */
    public function watermark($watermarkFilename, array $start = [0, 0])
    {
        \Yii::trace('watermark file', __METHOD__);

        $this->mark(__METHOD__, func_get_args());
//        $this->save(function () use ($watermarkFilename, $start) {
//            return Image::watermark($this->Media->getAbsolutePath(), $watermarkFilename, $start);
//        });
        $this->actions[] = function (&$Image) use ($watermarkFilename, $start) {
            return Image::watermark($Image, $watermarkFilename, $start);
        };

        return $this;
    }

    /**
     * @param string $text
     * @param string $fontFile
     * @param array $start
     * @param array $fontOptions
     * @return static
     */
    public function text($text, $fontFile, array $start = [0, 0], array $fontOptions = [])
    {
        \Yii::trace('text file', __METHOD__);

        $this->mark(__METHOD__, func_get_args());
//        $this->save(function () use ($text, $fontFile, $start, $fontOptions) {
//            return Image::text($this->Media->getAbsolutePath(), $text, $fontFile, $start, $fontOptions);
//        });
        $this->actions[] = function (&$Image) use ($text, $fontFile, $start, $fontOptions) {
            return Image::text($Image, $text, $fontFile, $start, $fontOptions);
        };

        return $this;
    }

    /**
     * @param int $margin
     * @param string $color
     * @param int $alpha
     * @return static
     */
    public function frame($margin = 20, $color = '666', $alpha = 100)
    {
        \Yii::trace('frame file', __METHOD__);

        $this->mark(__METHOD__, func_get_args());
//        $this->save(function () use ($margin, $color, $alpha) {
//            return Image::frame($this->Media->getAbsolutePath(), $margin, $color, $alpha);
//        });
        $this->actions[] = function (&$Image) use ($margin, $color, $alpha) {
            return Image::frame($Image, $margin, $color, $alpha);
        };

        return $this;
    }

    /**
     * @param string $filename
     * @return string
     */
    protected function calculatePathByFilename($filename)
    {
        $filename = basename($filename);
        $p1 = mb_substr($filename, 0, 2, \Yii::$app->charset);
        $p2 = mb_substr($filename, 2, 2, \Yii::$app->charset);

        return DIRECTORY_SEPARATOR . $p1 . DIRECTORY_SEPARATOR . $p2;
    }

    /**
     * @return string
     */
    protected function getAbsolutePath()
    {
        $p = $this->calculatePathByFilename($this->Media->name);

        /** @var \cookyii\modules\Media\resources\Media $MediaModel */
        $MediaModel = \Yii::createObject(\cookyii\modules\Media\resources\Media::className());

        return $MediaModel::getMediaModule()->storagePath . $p;
    }

    /**
     * @return string
     */
    protected function getWebPath()
    {
        $p = $this->calculatePathByFilename($this->Media->name);

        /** @var \cookyii\modules\Media\resources\Media $MediaModel */
        $MediaModel = \Yii::createObject(\cookyii\modules\Media\resources\Media::className());

        return $MediaModel::getMediaModule()->storageWebPath . $p;
    }

    /**
     * @param string $mark
     * @return string
     */
    protected function getMarkedMediaPath($mark)
    {
        \Yii::trace('calculate mark file path', __METHOD__);

        $ext = pathinfo($this->Media->name, PATHINFO_EXTENSION);

        return $this->getAbsolutePath() . DIRECTORY_SEPARATOR . $mark . '.' . $ext;
    }

    /**
     * @param string $mark
     * @return string
     */
    protected function getMarkedMediaWebPath($mark)
    {
        \Yii::trace('calculate mark file path', __METHOD__);

        $ext = pathinfo($this->Media->name, PATHINFO_EXTENSION);

        return $this->getWebPath() . '/' . $mark . '.' . $ext;
    }

    /**
     * @param string $mark
     */
    protected function createMarkedMedia($mark)
    {
        \Yii::beginProfile(sprintf('create cache file: %s', $this->Media->id), __METHOD__);

        $mark_file_path = $this->getMarkedMediaPath($mark);

        $mark_dir = dirname($mark_file_path);
        if (!file_exists($mark_dir) || !is_dir($mark_dir)) {
            FileHelper::createDirectory($mark_dir);
        }

        $Image = Image::getImagine()
            ->open(\Yii::getAlias($this->Media->getAbsolutePath()))
            ->copy();

        if (!empty($this->actions)) {
            foreach ($this->actions as $handler) {
                if (is_callable($handler)) {
                    $handler($Image);
                }
            }
        }

        $Image->save($mark_file_path, ['quality' => 90]);
        @chmod($mark_file_path, 0664);

        \Yii::endProfile(sprintf('create cache file: %s', $this->Media->id), __METHOD__);
    }


    /**
     * @param string $method
     * @param array $data
     */
    protected function mark($method, array $data)
    {
        $this->mark[] = func_get_args();
    }

    /**
     * @return \cookyii\modules\Media\Module
     */
    public static function getMediaModule()
    {
        /** @var \cookyii\modules\Media\Module|null $Module */
        $Module = \Yii::$app->getModule(static::$mediaModule);

        if (!($Module instanceof \cookyii\modules\Media\Module)) {
            throw new \RuntimeException(\Yii::t('app', 'Media module not configured'));
        }

        return $Module;
    }
}