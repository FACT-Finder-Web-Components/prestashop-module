<?php

namespace Omikron\Factfinder\Prestashop\Api;

use Omikron\Factfinder\Prestashop\Model\Api\ClientInterface;

class TestConnection
{
    /** @var ClientInterface */
    private $apiClient;

    /** @var string */
    private $apiQuery = 'FACT-Finder version';

    public function __construct(ClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @param string $endpoint
     * @param array  $params
     */
    public function execute($endpoint, array $params)
    {
        $this->apiClient->sendRequest(rtrim($endpoint, '/') . '/Search.ff', $params + ['query' => $this->apiQuery]);
    }
}
