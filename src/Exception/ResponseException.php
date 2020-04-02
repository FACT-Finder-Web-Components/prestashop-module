<?php

namespace Omikron\Factfinder\Prestashop\Exception;

class ResponseException extends \RuntimeException
{
    public function __construct($message, $code = 0, $previous = null) // phpcs:ignore
    {
        parent::__construct(($message ?: 'Response body was empty'), $code, $previous);
    }
}
