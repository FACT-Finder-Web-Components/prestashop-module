<?php

namespace Omikron\Factfinder\Prestashop\Settings;

abstract class AbstractSection
{
    /** @var callable */
    private $translate;

    public function __construct(callable $translate)
    {
        $this->translate = $translate;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function l($string)
    {
        return (string) call_user_func($this->translate, $string);
    }

    /**
     * Gets the form buttons definitions
     *
     * @return array
     */
    public function getButtons()
    {
        return [];
    }
}
