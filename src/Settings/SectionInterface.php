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

    /**
     * Gets the form buttons definitions
     *
     * @return array
     */
    public function getButtons();
}
