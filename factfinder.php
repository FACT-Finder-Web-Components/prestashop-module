<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

use Omikron\Factfinder\Prestashop\Config\CommunicationParams;
use Omikron\Factfinder\Prestashop\Config\FieldRoles;
use Omikron\Factfinder\Prestashop\FeaturesConfig;
use Omikron\Factfinder\Prestashop\Settings\SettingsForm;
use Omikron\Factfinder\Prestashop\Translate;
use PrestaShop\PrestaShop\Adapter\Admin\AbstractAdminQueryBuilder as QueryBuilder;
use PrestaShop\PrestaShop\Adapter\Presenter\Order\OrderPresenter;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class Factfinder extends Module implements WidgetInterface
{
    const WEB_COMPONENTS = 'ff-web-components-3.3.1';

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
            && $this->registerHook('actionAdminProductsListingFieldsModifier')
            && $this->registerHook('displayAfterBodyOpeningTag')
            && $this->registerHook('displayOrderConfirmation')
            && $this->registerHook('displayTop')
            && $this->registerHook('header')
            && $this->registerHook('moduleRoutes');
    }

    public function uninstall()
    {
        return parent::uninstall()
            && $this->unregisterHook('actionAdminProductsListingFieldsModifier')
            && $this->unregisterHook('displayAfterBodyOpeningTag')
            && $this->unregisterHook('displayOrderConfirmation')
            && $this->unregisterHook('displayTop')
            && $this->unregisterHook('header')
            && $this->unregisterHook('moduleRoutes');
    }

    public function hookHeader()
    {
        $this->registerStylesheet('classic.css', [], 'css');
        $this->registerStylesheet('suggest.css', [], 'css');
        $this->registerJavascript('vendor/custom-elements-es5-adapter.js');
        $this->registerJavascript('vendor/webcomponents-loader.js');
        $this->registerJavascript('bundle.js', ['attributes' => 'defer']);
    }

    public function hookActionAdminProductsListingFieldsModifier($sqlParts)
    {
        $sqlParts['sql_select']['description'] = [
            'table'     => 'pl',
            'field'     => 'description',
            'filtering' => QueryBuilder::FILTERING_LIKE_BOTH,
        ];

        $sqlParts['sql_select']['id_manufacturer'] = [
            'table' => 'p',
            'field' => 'id_manufacturer',
        ];

        $sqlParts['sql_select']['has_attributes'] = ['select' => 'IF(count(pa.id_product_attribute)>0, 1, 0)'];

        $sqlParts['sql_table']['pa'] = [
            'table' => 'product_attribute',
            'join'  => 'LEFT JOIN',
            'on'    => 'pa.`id_product` = p.`id_product`',
        ];

        $sqlParts['sql_group_by'][] = 'p.id_product';
    }

    public function hookModuleRoutes()
    {
        return [
            'ff-proxy' => [
                'controller' => 'proxy',
                'rule'       => 'FACT-Finder/{endpoint}',
                'keywords'   => [
                    'endpoint' => ['regexp' => '[A-Z][a-z]*\.ff', 'param' => 'endpoint'],
                ],
                'params'     => [
                    'ajax'   => true,
                    'fc'     => 'module',
                    'module' => $this->name,
                ],
            ],
        ];
    }

    public function hookDisplayOrderConfirmation(array $configuration)
    {
        $this->context->smarty->assign('order', (new OrderPresenter())->present($configuration['order']));
        return $this->display(__FILE__, 'checkout-tracking.tpl');
    }

    public function renderWidget($name, array $configuration)
    {
        $this->context->smarty->append('ff', $this->getWidgetVariables($name, $configuration), true);
        return $this->display(__FILE__, isset($this->templates[$name]) ? $this->templates[$name] : "{$name}.tpl");
    }

    public function getWidgetVariables($hookName, array $configuration)
    {
        return array_merge($configuration, [
            'communicationParams' => new CommunicationParams($this->context->language->id),
            'features'            => new FeaturesConfig(),
            'field_roles'         => new FieldRoles(),
            'img_path'            => "{$this->_path}views/images",
            'url'                 => ['search' => $this->context->link->getModuleLink($this->name, 'search')],
        ]);
    }

    public function getContent()
    {
        $this->context->controller->addJS($this->_path . 'views/js/ajax-action.js');

        $content  = '';
        $settings = SettingsForm::build(new Translate($this), $this->context);

        if ($settings->isSubmit()) { // @todo Add validation
            $settings->saveConfig();
            $content .= $this->displayConfirmation($this->l('The settings have been updated'));
        }

        $form         = new HelperForm();
        $form->module = $this;
        return $content . $settings->render($form);
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
