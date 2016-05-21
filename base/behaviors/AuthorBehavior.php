<?php
/**
 * AuthorBehavior.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\behaviors;

/**
 * Class AuthorBehavior
 * @package cookyii\behaviors
 */
class AuthorBehavior extends \yii\behaviors\BlameableBehavior
{

    /**
     * @inheritdoc
     */
    public $createdByAttribute = 'author_id';

    /**
     * @inheritdoc
     */
    public $updatedByAttribute = false;
}