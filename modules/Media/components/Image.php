<?php
/**
 * Image.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Media\components;

use Imagine;
use yii\helpers\ArrayHelper;

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
     * $obj->resizeByWidth($Image, 200);
     * $obj->resizeByWidth($Image, 150, \Imagine\Image\ImageInterface::FILTER_UNDEFINED);
     * ~~~
     *
     * @param Imagine\Image\ImageInterface $Image the image
     * @param integer $width the resize width
     * @param boolean $strict strict resize
     * @param string $filter
     * @return \Imagine\Image\ImageInterface
     */
    public static function resizeByWidth($Image, $width, $strict = false, $filter = Imagine\Image\ImageInterface::FILTER_UNDEFINED)
    {
        $size = $Image->getSize();

        if ($strict === false) {
            if ($width > $size->getWidth()) {
                $width = $size->getWidth();
            }
        }

        $height = $size->getHeight() / $size->getWidth() * $width;

        return $Image->resize(new Imagine\Image\Box($width, $height), $filter);
    }

    /**
     * Resize an image by height.
     *
     * For example,
     *
     * ~~~
     * $obj->resizeByHeight($Image, 200);
     * $obj->resizeByHeight($Image, 250, \Imagine\Image\ImageInterface::FILTER_UNDEFINED);
     * ~~~
     *
     * @param Imagine\Image\ImageInterface $Image the image
     * @param integer $height the resize height
     * @param boolean $strict strict resize
     * @param string $filter
     * @return \Imagine\Image\ImageInterface
     */
    public static function resizeByHeight($Image, $height, $strict = false, $filter = Imagine\Image\ImageInterface::FILTER_UNDEFINED)
    {
        $size = $Image->getSize();

        if ($strict === false) {
            if ($height > $size->getHeight()) {
                $height = $size->getHeight();
            }
        }

        $width = $size->getWidth() / $size->getHeight() * $height;

        return $Image->resize(new Imagine\Image\Box($width, $height), $filter);
    }

    /**
     * Strict resize an image.
     *
     * For example,
     *
     * ~~~
     * $obj->resize($Image, 200, 200);
     * $obj->resize($Image, 150, 250, \Imagine\Image\ImageInterface::FILTER_UNDEFINED);
     * ~~~
     *
     * @param Imagine\Image\ImageInterface $Image the image
     * @param integer $width the resize width
     * @param integer $height the resize height
     * @param boolean $strict strict resize
     * @param string $filter
     * @return \Imagine\Image\ImageInterface
     */
    public static function resize($Image, $width, $height, $strict = false, $filter = Imagine\Image\ImageInterface::FILTER_UNDEFINED)
    {
        $size = $Image->getSize();

        if ($strict === false) {
            if ($width > $size->getWidth()) {
                $width = $size->getWidth();
            }

            if ($height > $size->getHeight()) {
                $height = $size->getHeight();
            }
        }

        return $Image->resize(new Imagine\Image\Box($width, $height), $filter);
    }

    /**
     * Crops an image.
     *
     * For example,
     *
     * ~~~
     * $obj->crop($Image, 200, 200, [5, 5]);
     *
     * $point = new \Imagine\Image\Point(5, 5);
     * $obj->crop($Image, 200, 200, $point);
     * ~~~
     *
     * @param Imagine\Image\ImageInterface $Image the image
     * @param integer $width the crop width
     * @param integer $height the crop height
     * @param array $start the starting point. This must be an array with two elements representing `x` and `y` coordinates.
     * @return \Imagine\Image\ImageInterface
     * @throws \yii\base\InvalidParamException if the `$start` parameter is invalid
     */
    public static function crop($Image, $width, $height, array $start = [0, 0])
    {
        if (!isset($start[0], $start[1])) {
            throw new \yii\base\InvalidParamException('$start must be an array of two elements.');
        }

        return $Image->crop(new Imagine\Image\Point($start[0], $start[1]), new Imagine\Image\Box($width, $height));
    }

    /**
     * Creates a thumbnail image. The function differs from `\Imagine\Image\ImageInterface::thumbnail()` function that
     * it keeps the aspect ratio of the image.
     * @param Imagine\Image\ImageInterface $Image the image
     * @param integer $width the width in pixels to create the thumbnail
     * @param integer $height the height in pixels to create the thumbnail
     * @param string $mode
     * @return \Imagine\Image\ImageInterface
     */
    public static function thumbnail($Image, $width, $height, $mode = Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND)
    {
        $box = new Imagine\Image\Box($width, $height);

        $size = $Image->getSize();

        if (($size->getWidth() <= $box->getWidth() && $size->getHeight() <= $box->getHeight()) || (!$box->getWidth() && !$box->getHeight())) {
            return $Image->copy();
        }

        /** @var Imagine\Image\ImageInterface $Image */
        $Image = $Image->thumbnail($box, $mode);

        $Palette = new Imagine\Image\Palette\RGB;

        // create empty image to preserve aspect ratio of thumbnail
        $thumb = static::getImagine()->create($box, $Palette->color('#ffffff'));

        // calculate points
        $size = $Image->getSize();

        $startX = 0;
        $startY = 0;
        if ($size->getWidth() < $width) {
            $startX = ceil($width - $size->getWidth()) / 2;
        }
        if ($size->getHeight() < $height) {
            $startY = ceil($height - $size->getHeight()) / 2;
        }

        $thumb->paste($Image, new Imagine\Image\Point($startX, $startY));

        return $thumb;
    }

    /**
     * Adds a watermark to an existing image.
     * @param Imagine\Image\ImageInterface $Image the image
     * @param string $watermarkFilename the file path or path alias of the watermark image.
     * @param array $start the starting point. This must be an array with two elements representing `x` and `y` coordinates.
     * @return \Imagine\Image\ImageInterface
     * @throws \yii\base\InvalidParamException if `$start` is invalid
     */
    public static function watermark($Image, $watermarkFilename, array $start = [0, 0])
    {
        if (!isset($start[0], $start[1])) {
            throw new \yii\base\InvalidParamException('$start must be an array of two elements.');
        }

        $watermark = static::getImagine()
            ->open(\Yii::getAlias($watermarkFilename));

        $Image->paste($watermark, new Imagine\Image\Point($start[0], $start[1]));

        return $Image;
    }

    /**
     * Draws a text string on an existing image.
     * @param Imagine\Image\ImageInterface $Image the image
     * @param string $text the text to write to the image
     * @param string $fontFile the file path or path alias
     * @param array $start the starting position of the text. This must be an array with two elements representing `x` and `y` coordinates.
     * @param array $fontOptions the font options. The following options may be specified:
     *
     * - color: The font color. Defaults to "fff".
     * - size: The font size. Defaults to 12.
     * - angle: The angle to use to write the text. Defaults to 0.
     *
     * @return \Imagine\Image\ImageInterface
     * @throws \yii\base\InvalidParamException if `$fontOptions` is invalid
     */
    public static function text($Image, $text, $fontFile, array $start = [0, 0], array $fontOptions = [])
    {
        if (!isset($start[0], $start[1])) {
            throw new \yii\base\InvalidParamException('$start must be an array of two elements.');
        }

        $fontSize = ArrayHelper::getValue($fontOptions, 'size', 12);
        $fontColor = ArrayHelper::getValue($fontOptions, 'color', '#ffffff');
        $fontAngle = ArrayHelper::getValue($fontOptions, 'angle', 0);

        $Palette = new Imagine\Image\Palette\RGB;

        /** @var Imagine\Image\AbstractFont $font */
        $font = static::getImagine()
            ->font(\Yii::getAlias($fontFile), $fontSize, $Palette->color($fontColor));

        $Image->draw()->text($text, $font, new Imagine\Image\Point($start[0], $start[1]), $fontAngle);

        return $Image;
    }

    /**F
     * Adds a frame around of the image. Please note that the image size will increase by `$margin` x 2.
     * @param Imagine\Image\ImageInterface $Image the image
     * @param integer $margin the frame size to add around the image
     * @param string $color the frame color
     * @param integer|null $alpha the alpha value of the frame.
     * @return \Imagine\Image\ImageInterface
     */
    public static function frame($Image, $margin = 20, $color = '#666666', $alpha = null)
    {
        $size = $Image->getSize();

        $pasteTo = new Imagine\Image\Point($margin, $margin);
        $Palette = new Imagine\Image\Palette\RGB;

        $box = new Imagine\Image\Box($size->getWidth() + ceil($margin * 2), $size->getHeight() + ceil($margin * 2));

        $image = static::getImagine()->create($box, $Palette->color($color, $alpha));

        $image->paste($Image, $pasteTo);

        return $image;
    }
}
