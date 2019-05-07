<?php

namespace Omikron\Factfinder\Prestashop\DataTransferObject;

class AjaxResponse
{
    /** @var string */
    private $responseText;

    /** @var array */
    private $errors;

    public function __construct($responseText = '', $error = null)
    {
        $this->responseText = $responseText;
        $this->addError($error);
    }

    /**
     * @return string
     */
    public function getResponseText()
    {
        return $this->responseText;
    }

    /**
     * @param string $responseText
     */
    public function setResponseText($responseText)
    {
        $this->responseText = $responseText;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $error
     */
    public function addError($error)
    {
        $this->errors[] = $error;
    }
}
