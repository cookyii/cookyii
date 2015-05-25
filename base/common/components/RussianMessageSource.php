<?php
/**
 * RussianMessageSource.php
 * @author Revin Roman http://phptime.ru
 */

namespace common\components;

use yii\i18n\PhpMessageSource;

/**
 * Class RussianMessageSource
 * @package common\components
 */
class RussianMessageSource extends PhpMessageSource
{

    public $sourceLanguage = 'ru_RU';

    public $basePath = '@messages/';
} 