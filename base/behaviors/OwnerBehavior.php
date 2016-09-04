<?php
/**
 * OwnerBehavior.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\behaviors;

/**
 * Class OwnerBehavior
 * @package cookyii\behaviors
 */
class OwnerBehavior extends \yii\behaviors\BlameableBehavior
{

    /**
     * @inheritdoc
     */
    public $createdByAttribute = 'owner_id';

    /**
     * @inheritdoc
     */
    public $updatedByAttribute = false;
}
