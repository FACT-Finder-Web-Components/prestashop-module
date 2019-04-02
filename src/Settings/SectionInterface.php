<?php

namespace Omikron\Factfinder\Prestashop\Settings;

interface SectionInterface
{
    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return array
     */
    public function getFormFields();
}
