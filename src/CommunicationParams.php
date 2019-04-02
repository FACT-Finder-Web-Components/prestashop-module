<?php

namespace Omikron\Factfinder\Prestashop;

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
            'url'                         => \Configuration::get('FF_SERVER_URL'),
            'version'                     => \Configuration::get('FF_API_VERSION'),
            'default-query'               => \Configuration::get('FF_DEFAULT_QUERY') ?: '*',
            'channel'                     => \Configuration::get('FF_CHANNEL', $this->languageId),
            'use-url-parameter'           => \Configuration::get('FF_USE_URL_PARAMS') ? 'true' : 'false',
            'disable-single-hit-redirect' => \Configuration::get('FF_DISABLE_SINGLE_HIT_REDIRECTS') ? 'true' : 'false',
            'use-browser-history'         => \Configuration::get('FF_USE_BROWSER_CACHE') ? 'true' : 'false',
        ];
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getParameters());
    }
}
