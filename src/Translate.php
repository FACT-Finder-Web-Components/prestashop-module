<?php

namespace Omikron\Factfinder\Prestashop;

class Translate
{
    /** @var \Module */
    private $module;

    public function __construct(\Module $module)
    {
        $this->module = $module;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function __invoke($string)
    {
        return $this->l($string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function l($string)
    {
        return (string) $this->module->l($string);
    }
}
