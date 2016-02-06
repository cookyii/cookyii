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

    /** @var integer */
    public $resentTry = 3;

    /** @var integer */
    public $resentOffset = '+5 min';
}