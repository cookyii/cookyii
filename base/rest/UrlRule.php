<?php
/**
 * UrlRule.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\rest;

/**
 * Class UrlRule
 * @package cookyii\rest
 */
class UrlRule extends \yii\rest\UrlRule
{

    public $name = 'cookyii\rest\UrlRule';

    /**
     * @inheritdoc
     */
    public $tokens = [
        '{id}' => '<id:[a-zA-Z0-9\-]+>',
    ];

    /**
     * @inheritdoc
     */
    public $patterns = [
        'DELETE {id}' => 'delete',
        'PATCH {id}' => 'restore',
        'POST edit' => 'edit',
        'POST activate/{id}' => 'activate',
        'POST deactivate/{id}' => 'deactivate',
        'PUT {id}' => 'update',
        'POST' => 'create',
        'GET,HEAD detail/{id}' => 'detail',
        'GET,HEAD {id}' => 'view',
        'GET,HEAD' => 'index',
        '{id}' => 'options',
        '' => 'options',
    ];
}
