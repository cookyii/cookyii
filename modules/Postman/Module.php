<?php
/**
 * Module.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Postman;

/**
 * Class Module
 * @package cookyii\modules\Postman
 */
class Module extends \yii\base\Module
{

    /** @var string */
    public $from = 'Postman';

    /** @var string|null */
    public $subjectPrefix;

    /** @var string|null */
    public $subjectSuffix;
}