<?php

namespace Omikron\Factfinder\Prestashop\Model\Api;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Message\Response;
use Omikron\Factfinder\Prestashop\Config\AuthorizationParams;
use Omikron\Factfinder\Prestashop\Exception\ResponseException;
use Omikron\Factfinder\Prestashop\Serializer\SerializerInterface;

class Client implements ClientInterface
{
    /** @var HttpClient */
    private $client;

    /** @var AuthorizationParams */
    private $authorizationParams;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer          = $serializer;
        $this->authorizationParams = new AuthorizationParams();
        $this->client              = new HttpClient(['defaults' => ['headers' => ['Accept' => 'application/json']]]);
    }

    /**
     * @inheritDoc
     */
    public function sendRequest($endpoint, array $params = [])
    {
        $params = ['format' => 'json'] + $params + $this->getCredentials()->toArray();
        $query  = preg_replace('#products%5B\d+%5D%5B(.+?)%5D=#', '\1=', http_build_query($params));
        try {
            /** @var Response $response */
            $response = $this->client->get($endpoint . '?' . $query);
            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                return $this->serializer->unserialize((string) $response->getBody());
            }
        } catch (\Exception $e) {
            if ($e->getResponse()) {
                $this->badRequest($e->getResponse());
            }
            throw new ResponseException($e->getMessage()); // When request didn't take place
        }

        $this->badRequest($response);
    }

    /**
     * @return Credentials
     */
    private function getCredentials()
    {
        return new Credentials(
            $this->authorizationParams['username'],
            $this->authorizationParams['password'],
            $this->authorizationParams['authenticationPrefix'],
            $this->authorizationParams['authenticationPostfix']
        );
    }

    private function badRequest(Response $response)
    {
        $errorMessage = current($this->serializer->unserialize((string) $response->getBody()));
        throw new ResponseException((isset($errorMessage['error']) ? $errorMessage['error'] : $errorMessage), $response->getStatusCode());
    }
}
