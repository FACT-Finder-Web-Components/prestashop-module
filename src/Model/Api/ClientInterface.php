<?php

namespace Omikron\Factfinder\Prestashop\Model\Api;

use Omikron\Factfinder\Prestashop\Exception\ResponseException;

interface ClientInterface
{
    /**
     * Sends HTTP GET request to FACT-Finder. Returns the parsed server response.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @return array
     * @throws ResponseException
     */
    public function sendRequest($endpoint, array $params);
}
