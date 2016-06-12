<?php
/**
 * FormErrorsException.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\web;

use cookyii\base\FormModel;

/**
 * Class FormErrorsException
 * @package cookyii\web
 */
class FormErrorsException extends ErrorsException
{

    /**
     * FormErrorsException constructor.
     * @param FormModel|null $FormModel
     * @param string|null $message
     * @param integer|null $code
     * @param \Exception $previous
     */
    public function __construct(FormModel $FormModel = null, $message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct([], $message, $code, $previous);

        if (!empty($FormModel)) {
            $this->applyFirstErrors($FormModel);
        }
    }

    /**
     * @param FormModel $FormModel
     */
    public function applyFirstErrors(FormModel $FormModel)
    {
        $this->applyErrors($FormModel->getFirstErrors());
    }

    /**
     * @param FormModel $FormModel
     */
    public function applyAllErrors(FormModel $FormModel)
    {
        $this->applyErrors($FormModel->getErrors());
    }
}
