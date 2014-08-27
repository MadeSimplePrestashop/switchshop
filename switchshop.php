<?php

if (!defined('_PS_VERSION_'))
    exit;

/**
 * Module Switch Shop
 * @copyright 	kuzmany.biz/prestashop
 * Reminder: You own a single production license. It would only be installed on one online store (or multistore)
 */
class switchshop extends Module {

    const INPUT_USE = 'SWITCHSHOP_USE';
    const INPUT_TEMPLATE = 'SWITCHSHOP_TEMPLATE';
    const INPUT_SEPARATOR = 'SWITCHSHOP_SEPARATOR';

    public function __construct() {
        $this->name = 'switchshop';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'kuzmany.biz/prestashop';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Switch shop');
        $this->description = $this->l('Shop switcher for Prestashop');
    }

    public function install() {
        Configuration::updateValue(switchshop::INPUT_USE, 'all');
        Configuration::updateValue(switchshop::INPUT_TEMPLATE, 'dropdown');
        Configuration::updateValue(switchshop::INPUT_SEPARATOR, '/');
        return parent::install() && $this->registerHook('displayNav');
    }

    public function hookTop($params) {
        return $this->hookDisplayNav($params);
    }

    public function hookDisplayHeader($params) {
        return $this->hookDisplayNav($params);
    }

    public function hookDisplayNav($params) {
        if (Cache::retrieve(__FUNCTION__))
            return;
        else
            Cache::store(__FUNCTION__, true);

        if (Configuration::get(switchshop::INPUT_USE) == 'group')
            $shops = Shop::getShops(Shop::getContextShopGroup()->id);
        else
            $shops = Shop::getShops();

        foreach ($shops as $key => $shop) {
            $id_lang_shop = Configuration::get('PS_LANG_DEFAULT', null, null, $shop['id_shop']);
            $lang = new Language($id_lang_shop);
            $shops[$key]['lang'] = $lang;
        }
        $this->context->smarty->assign(array(
            'shops' => $shops,
            'current_shop_id' => Shop::getContextShopID(),
            'uri_protocol' => $this->context->link->protocol_content,
            'separator' => Configuration::get(switchshop::INPUT_SEPARATOR)
        ));
        if (Configuration::get(switchshop::INPUT_TEMPLATE) == 'separator')
            return $this->display(__FILE__, 'blockshop_separator.tpl');
        else
            return $this->display(__FILE__, 'blockshop_dropdown.tpl');
    }

    public function getContent() {
        return (!Shop::isFeatureActive() ? $this->displayError('Multishop feature is not enabled.') : '')
                . $this->postProcess()
                . $this->renderForm();
    }

    public function postProcess() {
        if (Tools::isSubmit('submitStoreConf')) {
            Configuration::updateValue(switchshop::INPUT_USE, Tools::getValue(switchshop::INPUT_USE));
            Configuration::updateValue(switchshop::INPUT_TEMPLATE, Tools::getValue(switchshop::INPUT_TEMPLATE));
            Configuration::updateValue(switchshop::INPUT_SEPARATOR, Tools::getValue(switchshop::INPUT_SEPARATOR));
            return $this->displayConfirmation($this->l('The settings have been updated.'));
        }
    }

    public function renderForm() {

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuration'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Usage'),
                        'name' => switchshop::INPUT_USE,
                        'values' => array(
                            array(
                                'id' => 'all',
                                'value' => 'all',
                                'label' => $this->l('All shops')
                            ),
                            array(
                                'id' => 'group',
                                'value' => 'group',
                                'label' => $this->l('Only from group')
                            ),
                        )
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Template'),
                        'name' => switchshop::INPUT_TEMPLATE,
                        'values' => array(
                            array(
                                'id' => 'dropdown',
                                'value' => 'dropdown',
                                'label' => $this->l('Dropdown')
                            ),
                            array(
                                'id' => 'separator',
                                'value' => 'separator',
                                'label' => $this->l('Separator'),
                            ),
                        )
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Separator'),
                        'size' => 5,
                        'name' => switchshop::INPUT_SEPARATOR,
                        'default_value' => '/',
                        'desc' => $this->l('Only for separator template')
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save')
                )
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int) Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->module = $this;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitStoreConf';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $values = array();
        $values[switchshop::INPUT_USE] = Configuration::get(switchshop::INPUT_USE);
        $values[switchshop::INPUT_TEMPLATE] = Configuration::get(switchshop::INPUT_TEMPLATE);
        $values[switchshop::INPUT_SEPARATOR] = Configuration::get(switchshop::INPUT_SEPARATOR);

        $helper->tpl_vars = array(
            'uri' => $this->getPathUri(),
            'fields_value' => $values,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));
    }

}
