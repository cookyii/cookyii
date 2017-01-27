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

    /**
     * @var string
     */
    public $from = [SMTP_USER => 'Postman'];

    /**
     * @var string|null
     */
    public $subjectPrefix;

    /**
     * @var string|null
     */
    public $subjectSuffix;

    /**
     * @var integer
     */
    public $resentTry = 3;

    /**
     * @var integer
     */
    public $resentOffset = '+5 min';

    /**
     * @var bool
     */
    public $usePremailer = false;

    /**
     * @var string
     */
    public $defaultLayout = 'database';

    /**
     * @var array
     */
    public $layoutVariants = [];
}