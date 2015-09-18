<?php
/**
 * Image.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Media\components;

use Imagine;

/**
 * Class Image
 * @package cookyii\modules\Media\components
 */
class Image extends \yii\imagine\Image
{

    /**
     * Resize an image by width.
     *
     * For example,
     *
     * ~~~
     * $obj->resizeByWidth('path\to\image.jpg', 200);
     * $obj->resizeByWidth('path\to\image.jpg', 150, \Imagine\Image\ImageInterface::FILTER_UNDEFINED);
     * ~~~
     *
     * @param string $filename the image file path or path alias.
     * @param integer $width the resize width
     * @param boolean $strict strict resize
     * @param string $filter
     * @return \Imagine\Image\ImageInterface
     */
    public static function resizeByWidth($filename, $width, $strict = false, $filter = Imagine\Image\ImageInterface::FILTER_UNDEFINED)
    {
        $img = static::getImagine()
            ->open(\Yii::getAlias($filename));

        $size = $img->getSize();

        if ($strict === false) {
            if ($width > $size->getWidth()) {
                $width = $size->getWidth();
            }
        }

        $height = $size->getHeight() / $size->getWidth() * $width;

        return $img->copy()
            ->resize(new Imagine\Image\Box($width, $height), $filter);
    }

    /**
     * Resize an image by height.
     *
     * For example,
     *
     * ~~~
     * $obj->resizeByHeight('path\to\image.jpg', 200);
     * $obj->resizeByHeight('path\to\image.jpg', 250, \Imagine\Image\ImageInterface::FILTER_UNDEFINED);
     * ~~~
     *
     * @param string $filename the image file path or path alias.
     * @param integer $height the resize height
     * @param boolean $strict strict resize
     * @param string $filter
     * @return \Imagine\Image\ImageInterface
     */
    public static function resizeByHeight($filename, $height, $strict = false, $filter = Imagine\Image\ImageInterface::FILTER_UNDEFINED)
    {
        $img = static::getImagine()
            ->open(\Yii::getAlias($filename));

        $size = $img->getSize();

        if ($strict === false) {
            if ($height > $size->getHeight()) {
                $height = $size->getHeight();
            }
        }

        $width = $size->getWidth() / $size->getHeight() * $height;

        return $img->copy()
            ->resize(new Imagine\Image\Box($width, $height), $filter);
    }

    /**
     * Strict resize an image.
     *
     * For example,
     *
     * ~~~
     * $obj->resize('path\to\image.jpg', 200, 200);
     * $obj->resize('path\to\image.jpg', 150, 250, \Imagine\Image\ImageInterface::FILTER_UNDEFINED);
     * ~~~
     *
     * @param string $filename the image file path or path alias.
     * @param integer $width the resize width
     * @param integer $height the resize height
     * @param boolean $strict strict resize
     * @param string $filter
     * @return \Imagine\Image\ImageInterface
     */
    public static function resize($filename, $width, $height, $strict = false, $filter = Imagine\Image\ImageInterface::FILTER_UNDEFINED)
    {
        $img = static::getImagine()
            ->open(\Yii::getAlias($filename));

        $size = $img->getSize();

        if ($strict === false) {
            if ($width > $size->getWidth()) {
                $width = $size->getWidth();
            }

            if ($height > $size->getHeight()) {
                $height = $size->getHeight();
            }
        }

        return $img->copy()
            ->resize(new Imagine\Image\Box($width, $height), $filter);
    }
}