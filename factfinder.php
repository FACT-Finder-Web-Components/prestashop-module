<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

use Omikron\Factfinder\Prestashop\CommunicationParams;
use Omikron\Factfinder\Prestashop\Settings\SettingsForm;
use Omikron\Factfinder\Prestashop\Translate;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class Factfinder extends Module implements WidgetInterface
{
    const WEB_COMPONENTS = 'ff-web-components-3.1.1';

    /** @var string */
    public $name = 'factfinder';

    /** @var string */
    public $version = '1.0.0';

    /** @var string */
    public $author = 'Omikron Data Quality GmbH';

    /** @var string */
    public $author_uri = 'https://web-components.fact-finder.de/';

    /** @var string */
    public $tab = 'front_office_features';

    /** @var string */
    public $need_instance = 0;

    /** @var bool */
    public $bootstrap = true;

    /** @var array */
    public $ps_versions_compliancy = [
        'min' => '1.7',
        'max' => _PS_VERSION_,
    ];

    /** @var array */
    public $controllers = ['search'];

    /** @var array */
    private $templates = [
        'displayAfterBodyOpeningTag' => 'communication.tpl',
        'displayTop'                 => 'searchbox.tpl',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->displayName      = $this->l('FACT-Finder®');
        $this->description      = $this->l('FACT-Finder® WebComponents integration for PrestaShop');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('displayAfterBodyOpeningTag')
            && $this->registerHook('displayTop')
            && $this->registerHook('header');
    }

    public function uninstall()
    {
        return parent::uninstall()
            && $this->unregisterHook('displayAfterBodyOpeningTag')
            && $this->unregisterHook('displayTop')
            && $this->unregisterHook('header');
    }

    public function hookHeader()
    {
        $this->registerStylesheet('default-styles.css');
        $this->registerStylesheet('classic.css', [], 'css');
        $this->registerJavascript('vendor/custom-elements-es5-adapter.js');
        $this->registerJavascript('vendor/webcomponents-loader.js');
        $this->registerJavascript('bundle.js', ['attributes' => 'defer']);
    }

    public function renderWidget($name, array $configuration)
    {
        $this->context->smarty->assign('ff', $this->getWidgetVariables($name, $configuration));
        return $this->display(__FILE__, isset($this->templates[$name]) ? $this->templates[$name] : "{$name}.tpl");
    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        return [
            'communicationParams' => new CommunicationParams($this->context->language->id),
            'img_path'            => "{$this->_path}views/images",
            'suggest'             => (bool) \Configuration::get('FF_FEATURE_SUGGEST'),
            'url'                 => ['search' => $this->context->link->getModuleLink($this->name, 'search')],
        ];
    }

    public function getContent()
    {
        $content  = '';
        $settings = SettingsForm::build(new Translate($this), $this->context);

        if ($settings->isSubmit()) { // @todo Add validation
            $settings->saveConfig();
            $content .= $this->displayConfirmation($this->l('The settings have been updated'));
        }

        return $content . $settings->render(new HelperForm());
    }

    private function registerStylesheet($path, array $params = [], $base = self::WEB_COMPONENTS)
    {
        $path = "modules/{$this->name}/views/{$base}/{$path}";
        $this->context->controller->registerStylesheet('ff-' . md5($path), $path, $params);
    }

    private function registerJavascript($path, array $params = [], $base = self::WEB_COMPONENTS)
    {
        $path = "modules/{$this->name}/views/{$base}/{$path}";
        $this->context->controller->registerJavascript('ff-' . md5($path), $path, $params + ['position' => 'head']);
    }
}
