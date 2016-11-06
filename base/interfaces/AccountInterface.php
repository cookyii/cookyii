<?php
/**
 * AccountInterface.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\interfaces;

/**
 * Class AccountInterface
 * @package cookyii\interfaces
 */
interface AccountInterface
{

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId();

    /**
     * Returns an user name.
     * @return string an user name.
     */
    public function getName();
}
