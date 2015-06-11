<?php
/**
 * UrlRule.php
 * @author Revin Roman
 */

namespace common\rest;

/**
 * Class UrlRule
 * @package common\rest
 */
class UrlRule extends \yii\rest\UrlRule
{

    public $patterns = [
        'PUT {id}' => 'update',
        'PATCH {id}' => 'restore',
        'DELETE {id}' => 'delete',
        'GET,HEAD {id}' => 'view',
        'POST' => 'create',
        'GET,HEAD' => 'index',
        '{id}' => 'options',
        '' => 'options',
    ];
}