<?php
/**
 * ResourceInterface.php
 * @author Revin Roman
 */

namespace cookyii\modules\Media\resources;

/**
 * Interface ResourceInterface
 * @package cookyii\modules\Media\resources
 */
interface ResourceInterface
{

    /**
     * @param mixed $source
     */
    public function setSource($source);

    /**
     * @return string
     */
    public function getName();

    public function getSize();

    public function getMime();

    /**
     * @return string
     */
    public function getTemp();

    /**
     * @return string
     */
    public function getSha1();

    /**
     * @return string|false
     */
    public function moveToUpload();
}