<?php
/**
 * InternalResource.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Media\media;

/**
 * Class InternalResource
 * @package cookyii\modules\Media\media
 */
class InternalResource extends AbstractResource implements ResourceInterface
{

    /** @var string */
    private $temp;

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->temp = $source;

        if (!file_exists($this->temp) || !is_file($this->temp)) {
            throw new \RuntimeException('Internal resource not available');
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return basename($this->temp);
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return filesize($this->temp);
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getMime()
    {
        return \yii\helpers\FileHelper::getMimeType($this->temp);
    }

    /**
     * @return string
     */
    public function getTemp()
    {
        return $this->temp;
    }

    public function clear()
    {
        // override deleting original file
    }
}