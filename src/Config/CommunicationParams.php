<?php

namespace Omikron\Factfinder\Prestashop\Config;

class CommunicationParams implements \IteratorAggregate
{
    /** @var int */
    private $languageId;

    public function __construct($languageId = 0)
    {
        $this->languageId = (int) $languageId;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return [
            'url'                         => $this->getServerUrl($this->useProxy()),
            'version'                     => \Configuration::get('FF_API_VERSION'),
            'default-query'               => \Configuration::get('FF_DEFAULT_QUERY') ?: '*',
            'channel'                     => \Configuration::get('FF_CHANNEL', $this->languageId),
            'use-url-parameter'           => \Configuration::get('FF_USE_URL_PARAMS') ? 'true' : 'false',
            'disable-single-hit-redirect' => \Configuration::get('FF_DISABLE_SINGLE_HIT_REDIRECTS') ? 'true' : 'false',
            'use-browser-history'         => \Configuration::get('FF_USE_BROWSER_CACHE') ? 'true' : 'false',
            'add-params'                  => \Configuration::get('FF_ADD_PARAMS'),
        ];
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getParameters());
    }

    /**
     * @param bool $useProxy
     *
     * @return string
     */
    public function getServerUrl($useProxy = false)
    {
        return $useProxy
            ? (new \Link())->getPageLink('ff-proxy', null, null, ['endpoint' => ''])
            : rtrim(\Configuration::get('FF_SERVER_URL', '/'));
    }

    private function useProxy()
    {
        return false; // @todo Should we let the user decide?
    }
}
