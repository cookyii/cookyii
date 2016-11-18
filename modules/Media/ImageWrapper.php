<?php
/**
 * ImageWrapper.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Media;

use cookyii\modules\Media;
use cookyii\modules\Media\resources\Media\Model as MediaModel;
use Imagine\Image\ImageInterface;
use Imagine\Image\ManipulatorInterface;
use yii\helpers\FileHelper;

/**
 * Class ImageWrapper
 * @package cookyii\modules\Media
 */
class ImageWrapper extends \yii\base\Object
{

    /**
     * @var string
     */
    public static $mediaModule = 'media';

    /**
     * @var MediaModel
     */
    public $Media = null;

    /**
     * @var array
     */
    public $result = [null, null];

    /**
     * @var array
     */
    protected $mark = [];

    /**
     * @var array
     */
    protected $actions = [];

    /**
     * @var ImageInterface
     */
    protected $imagine;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $Media = $this->Media;

        if (!($Media instanceof MediaModel)) {
            throw new \yii\base\InvalidConfigException(\Yii::t('cookyii', 'Model must be `{class}`.', [
                'class' => MediaModel::class,
            ]));
        }
    }

    /**
     * @return string
     */
    public function export()
    {
        $mark = sha1(serialize($this->mark));

        $mediaAbsolutePath = $this->getMarkedMediaPath($mark);

        if (!file_exists($mediaAbsolutePath)) {
            \Yii::trace(sprintf('create new file cache: ', $this->Media->id), __METHOD__);
            $this->createMarkedMediaFile($mark);
        } else {
            \Yii::trace(sprintf('file already cached: %s (%s)', $this->Media->id, serialize($this->mark)), __METHOD__);
        }

        \Yii::endProfile(sprintf('manipulating with file `%s`', $this->Media->id), 'Media\Manipulation');

        return $this->getMarkedMediaWebPath($mark);
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

        $this->addMarkItem(
            __METHOD__,
            func_get_args(),
            function ($Image) use ($width, $height, $strict, $filter) {
                return Media\components\Image::resize($Image, $width, $height, $strict, $filter);
            }
        );

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

        $this->addMarkItem(
            __METHOD__,
            func_get_args(),
            function ($Image) use ($width, $strict, $filter) {
                return Media\components\Image::resizeByWidth($Image, $width, $strict, $filter);
            }
        );

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

        $this->addMarkItem(
            __METHOD__,
            func_get_args(),
            function ($Image) use ($height, $strict, $filter) {
                return Media\components\Image::resizeByHeight($Image, $height, $strict, $filter);
            }
        );

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

        $this->addMarkItem(
            __METHOD__,
            func_get_args(),
            function ($Image) use ($width, $height, $start) {
                return Media\components\Image::crop($Image, $width, $height, $start);
            }
        );

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

        $this->addMarkItem(
            __METHOD__,
            func_get_args(),
            function ($Image) use ($width, $height, $mode) {
                return Media\components\Image::thumbnail($Image, $width, $height, $mode);
            }
        );

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

        $this->addMarkItem(
            __METHOD__,
            func_get_args(),
            function ($Image) use ($watermarkFilename, $start) {
                return Media\components\Image::watermark($Image, $watermarkFilename, $start);
            }
        );

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

        $this->addMarkItem(
            __METHOD__,
            func_get_args(),
            function ($Image) use ($text, $fontFile, $start, $fontOptions) {
                return Media\components\Image::text($Image, $text, $fontFile, $start, $fontOptions);
            }
        );

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

        $this->addMarkItem(
            __METHOD__,
            func_get_args(),
            function ($Image) use ($margin, $color, $alpha) {
                return Media\components\Image::frame($Image, $margin, $color, $alpha);
            }
        );

        return $this;
    }

    /**
     * @param string $filename
     * @param string $separator
     * @return string
     */
    protected function calculatePathByFilename($filename, $separator)
    {
        $charset = \Yii::$app->charset;

        $filename = basename($filename);

        $p1 = mb_substr($filename, 0, 2, $charset);
        $p2 = mb_substr($filename, 2, 2, $charset);

        return $separator . $p1 . $separator . $p2;
    }

    /**
     * @param string $separator
     * @return string
     */
    protected function getAbsolutePath($separator)
    {
        $p = $this->calculatePathByFilename($this->Media->name, $separator);

        /** @var MediaModel $MediaModel */
        $MediaModel = \Yii::createObject(MediaModel::class);

        return $MediaModel::getMediaModule()->storagePath . $p;
    }

    /**
     * @param string $separator
     * @return string
     */
    protected function getWebPath($separator)
    {
        $p = $this->calculatePathByFilename($this->Media->name, $separator);

        /** @var MediaModel $MediaModel */
        $MediaModel = \Yii::createObject(MediaModel::class);

        return $MediaModel::getMediaModule()->storageWebPath . $p;
    }

    /**
     * @param string $mark
     * @param string $separator
     * @return string
     */
    protected function getMarkedMediaPath($mark, $separator = DIRECTORY_SEPARATOR)
    {
        $Media = $this->Media;

        return $this->getAbsolutePath($separator) . $separator . $mark . '.' . $Media->getExt();
    }

    /**
     * @param string $mark
     * @param string $separator
     * @return string
     */
    protected function getMarkedMediaWebPath($mark, $separator = '/')
    {
        $Media = $this->Media;

        return $this->getWebPath($separator) . $separator . $mark . '.' . $Media->getExt();
    }

    /**
     * @param string $mark
     */
    protected function createMarkedMediaFile($mark)
    {
        $Media = $this->Media;

        \Yii::beginProfile(sprintf('create cache file: %s', $Media->id), __METHOD__);

        $this->imagine = Media\components\Image::getImagine()
            ->open(\Yii::getAlias($Media->getAbsolutePath()));

        /** @var MediaModel $MediaModel */
        $MediaModel = \Yii::createObject(MediaModel::class);

        $mark_file_path = $this->getMarkedMediaPath($mark);

        $mark_dir = dirname($mark_file_path);
        if (!file_exists($mark_dir) || !is_dir($mark_dir)) {
            FileHelper::createDirectory($mark_dir, $MediaModel::getMediaModule()->pathChmod);
        }

        $Image = $this->imagine->copy();

        if (!empty($this->actions)) {
            foreach ($this->actions as $handler) {
                if (is_callable($handler)) {
                    $Image = $handler($Image);
                }
            }
        }

        $Image->save($mark_file_path, ['quality' => 90]);
        @chmod($mark_file_path, $MediaModel::getMediaModule()->fileChmod);

        \Yii::endProfile(sprintf('create cache file: %s', $Media->id), __METHOD__);
    }

    /**
     * @param string $method
     * @param array $data
     * @param callable $handler
     */
    protected function addMarkItem($method, array $data, callable $handler)
    {
        $this->mark[] = func_get_args();

        $this->actions[] = $handler;
    }
}
