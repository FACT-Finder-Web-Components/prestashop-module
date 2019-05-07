<?php

namespace Omikron\Factfinder\Prestashop\DataTransferObject;

class TestConnectionParams
{
    /** @var  string */
    private $username;

    /** @var string */
    private $password;

    /** @var string */
    private $url;

    /** @var string */
    private $channel;

    /** @var string */
    private $authenticationPrefix;

    /** @var string */
    private $authenticationPostfix;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param string $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }

    /**
     * @return string
     */
    public function getAuthenticationPrefix()
    {
        return $this->authenticationPrefix;
    }

    /**
     * @param string $authenticationPrefix
     */
    public function setAuthenticationPrefix($authenticationPrefix)
    {
        $this->authenticationPrefix = $authenticationPrefix;
    }

    /**
     * @return string
     */
    public function getAuthenticationPostfix()
    {
        return $this->authenticationPostfix;
    }

    /**
     * @param string $authenticationPostfix
     */
    public function setAuthenticationPostfix($authenticationPostfix)
    {
        $this->authenticationPostfix = $authenticationPostfix;
    }
}
