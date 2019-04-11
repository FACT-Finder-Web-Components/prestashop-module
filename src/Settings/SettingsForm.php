<?php

namespace Omikron\Factfinder\Prestashop\Settings;

use Omikron\Factfinder\Prestashop\Translate;

class SettingsForm
{
    const ACTION_SUBMIT = 'btnSubmit';

    /** @var SectionInterface[] */
    private $sections;

    /** @var \Context */
    private $context;

    /** @var callable */
    private $translate;

    /**
     * SettingsForm constructor.
     *
     * @param \Context $context
     * @param callable $translate
     * @param array    $sections
     */
    public function __construct(\Context $context, callable $translate, array $sections)
    {
        $this->context   = $context;
        $this->translate = $translate;
        $this->sections  = $sections;
    }

    /**
     * @param Translate $translate
     * @param \Context  $context
     *
     * @return SettingsForm
     */
    public static function build(Translate $translate, \Context $context)
    {
        return new static($context, $translate, [
            new GeneralSettings($translate),
            new CommunicationSettings($translate),
            new FeatureSettings($translate),
            new ExportSettings($translate),
        ]);
    }

    /**
     * @return bool
     */
    public function isSubmit()
    {
        return \Tools::isSubmit(self::ACTION_SUBMIT);
    }

    public function saveConfig()
    {
        foreach ($this->allFields() as list($name, $lang, $multiSelect)) {
            if ($multiSelect) {
                \Configuration::updateValue($name, implode(',', (array) \Tools::getValue($name, [])));
                continue;
            }
            \Configuration::updateValue($name, $lang ? $this->getLocalizedValue($name) : $this->getValue($name));
        }
    }

    /**
     * @param \HelperForm $helper
     *
     * @return string
     */
    public function render(\HelperForm $helper)
    {
        $helper->default_form_language = $this->getDefaultLanguage();
        $helper->languages             = $this->getLanguages();
        $helper->fields_value          = $this->getFieldValues();
        $helper->submit_action         = self::ACTION_SUBMIT;
        $helper->token                 = \Tools::getAdminTokenLite('AdminModules');
        return $helper->generateForm($this->getFormDefinition());
    }

    /**
     * @return array
     */
    private function getFormDefinition()
    {
        return array_map(function (SectionInterface $section) {
            return [
                'form' => [
                    'legend' => ['title' => $section->getTitle(), 'icon' => 'icon-cogs'],
                    'input'  => $section->getFormFields(),
                    'submit' => ['title' => $this->l('Save')],
                ],
            ];
        }, $this->sections);
    }

    /**
     * @return array
     */
    private function getFieldValues()
    {
        $values = [];
        foreach ($this->allFields() as list($name, $lang, $multiSelect)) {
            $value = $lang ? \Configuration::getInt($name) : \Configuration::get($name);
            if ($multiSelect) {
                $name  = "{$name}[]";
                $value = explode(',', $value);
            }
            $values[$name] = $value;
        }
        return $values;
    }

    /**
     * @return array
     */
    private function allFields()
    {
        return array_merge([], ...array_map(function (SectionInterface $section) {
            return array_map(function (array $field) {
                return [
                    $field['name'],
                    isset($field['lang']) ? $field['lang'] : false,
                    $field['type'] == 'select' && isset($field['multiple']) && $field['multiple'] === true,
                ];
            }, $section->getFormFields());
        }, $this->sections));
    }

    /**
     * @return array
     */
    private function getLanguages()
    {
        return $this->context->controller->getLanguages();
    }

    /**
     * @return int
     */
    private function getDefaultLanguage()
    {
        return array_reduce($this->getLanguages(), function ($res, array $lang) {
            return $lang['is_default'] ? (int) $lang['id_lang'] : $res;
        }, -1);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    private function l($string)
    {
        return (string) call_user_func($this->translate, $string);
    }

    /**
     * @param string $name
     * @param int    $lang
     *
     * @return string
     */
    private function getValue($name, $lang = 0)
    {
        $name = $lang ? "{$name}_{$lang}" : $name;
        return trim(\Tools::getValue($name, \Configuration::get($name, $lang)));
    }

    /**
     * @param string $name
     *
     * @return array
     */
    private function getLocalizedValue($name)
    {
        $values = [];
        foreach ($this->getLanguages() as $lang) {
            $values[$lang['id_lang']] = $this->getValue($name, $lang['id_lang']);
        }
        return $values;
    }
}
