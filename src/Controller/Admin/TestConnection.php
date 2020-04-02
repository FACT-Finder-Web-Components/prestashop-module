<?php

namespace Omikron\Factfinder\Prestashop\Controller\Admin;

use Omikron\Factfinder\Prestashop\Api\TestConnection as ApiTestConnection;
use Omikron\Factfinder\Prestashop\DataTransferObject\AjaxResponse;
use Omikron\Factfinder\Prestashop\DataTransferObject\TestConnectionParams;
use Omikron\Factfinder\Prestashop\Exception\ResponseException;
use Omikron\Factfinder\Prestashop\Model\Api\Credentials;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;

class TestConnection extends FrameworkBundleAdminController
{
    public function testConnectionAction(TestConnectionParams $testParams)
    {
        /** @var ApiTestConnection $testConnection */
        $testConnection = $this->get('factfinder.api_test_connection');

        try {
            $params = ['channel' => $testParams->getChannel(), 'verbose' => true];
            $testConnection->execute($testParams->getUrl(), $params + $this->getCredentials($testParams)->toArray());
            return $this->json(new AjaxResponse('Connection successfully established.'));
        } catch (ResponseException $e) {
            return $this->json(new AjaxResponse('Test connection error', $e->getMessage()), 400);
        }
    }

    /**
     * @param TestConnectionParams $params
     *
     * @return Credentials
     */
    private function getCredentials(TestConnectionParams $params)
    {
        return new Credentials(
            $params->getUsername(),
            $params->getPassword(),
            $params->getAuthenticationPrefix(),
            $params->getAuthenticationPostfix()
        );
    }
}
