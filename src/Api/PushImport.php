<?php

namespace Omikron\Factfinder\Prestashop\Api;

use Omikron\Factfinder\Prestashop\Config\CommunicationParams;
use Omikron\Factfinder\Prestashop\Model\Api\ClientInterface;

class PushImport
{
    /** @var ClientInterface */
    private $apiClient;

    /** @var string */
    protected $apiName = 'Import.ff';

    public function __construct(ClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function execute(array $params = [])
    {
        if (!$this->isPushImportEnabled()) {
            return false;
        }
        $communicationParams = (new CommunicationParams($this->langId()))->getParameters();
        $params              += [
            'channel'  => $communicationParams['channel'],
            'quiet'    => 'true',
            'download' => 'true',
        ];

        $response = [];
        $endpoint = $communicationParams['url'] . '/' . $this->apiName;
        foreach ($this->getPushImportDataTypes() as $type) {
            $params['type'] = $type;
            $response       = array_merge_recursive($response, $this->apiClient->sendRequest($endpoint, $params));
        }

        return $response && !(isset($response['errors']) || isset($response['error']));
    }

    /**
     * @return array
     */
    private function getPushImportDataTypes()
    {
        return explode(',', \Configuration::get('FF_PUSHED_IMPORT_TYPES', $this->langId()));
    }

    /**
     * @return bool
     */
    private function isPushImportEnabled()
    {
        return (bool) \Configuration::get('FF_AUTOMATIC_IMPORT', $this->langId());
    }

    /**
     * @return int
     */
    private function langId()
    {
        return \Context::getContext()->language->id;
    }
}
