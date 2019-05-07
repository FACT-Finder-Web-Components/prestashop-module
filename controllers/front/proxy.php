<?php

use Omikron\Factfinder\Prestashop\Config\CommunicationParams;
use Omikron\Factfinder\Prestashop\Model\Api\Client as ApiClient;
use Omikron\Factfinder\Prestashop\Serializer\Json as JsonSerializer;

class FactfinderProxyModuleFrontController extends ModuleFrontController
{
    /** @var ApiClient */
    private $apiClient;

    /** @var CommunicationParams */
    private $communicationParams;

    /** @var JsonSerializer */
    private $serializer;

    public function __construct()
    {
        parent::__construct();
        $this->serializer          = new JsonSerializer();
        $this->apiClient           = new ApiClient($this->serializer);
        $this->communicationParams = new CommunicationParams($this->context->language->id);
    }

    protected function buildContainer()
    {
        $container = parent::buildContainer();
        return $container;
    }

    public function displayAjax()
    {
        header('Content-Type: application/json');
        $response = $this->sendRequest(Tools::getValue('endpoint'), $this->getParams());
        $this->ajaxRender($this->serializer->serialize($response));
    }

    private function sendRequest($endpoint, array $params)
    {
        return $this->apiClient->sendRequest("{$this->communicationParams->getServerUrl()}/{$endpoint}", $params);
    }

    private function getParams()
    {
        return (array) Tools::getAllValues();
    }
}
