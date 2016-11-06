<?php
/**
 * RenderEvent.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\base;

/**
 * Class RenderEvent
 * @package cookyii\base
 */
class RenderEvent extends Event
{

    /**
     * @var string|null
     */
    public $class;

    /**
     * @var string|null
     */
    public $method;

    /**
     * @var array|null
     */
    public $options;
}
