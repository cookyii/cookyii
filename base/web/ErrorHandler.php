<?php
/**
 * ErrorHandler.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\web;

/**
 * Class ErrorHandler
 * @package cookyii\web
 */
class ErrorHandler extends \yii\web\ErrorHandler
{

    /**
     * @inheritdoc
     */
    protected function convertExceptionToArray($exception)
    {
        $array = parent::convertExceptionToArray($exception);

        if ($exception instanceof FormErrorsException) {
            $array['errors'] = $exception->errors;
        }

        return $array;
    }
}