<?php

if (!defined('_PS_VERSION_'))
    exit;

class switchshop extends Module {
    /* @var boolean error */

    protected $_errors = false;

    public function __construct() {
        $this->name = 'switchshop';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'kuzmany.biz/prestashop';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Switch shop');
        $this->description = $this->l('Shop switcher for Prestashop');
    }

    public function install() {
        return parent::install() && $this->registerHook('displayNav') && $this->registerHook('displayHeader') && $this->registerHook('top');
    }

    public function hookTop($params) {
        return $this->hookDisplayNav($params);
    }

    /**
     * Returns module content for header
     *
     * @param array $params Parameters
     * @return string Content
     */
    public function hookDisplayNav($params) {
        if (Cache::retrieve(__FUNCTION__))
            return;
        else
            Cache::store (__FUNCTION__, true);
        //if (Shop::isFeatureActive())
        //echo Shop::getContextShopID();
        //print_R(Shop::getContextShopGroup());
        //echo $this->context->link->protocol_content;
        $shops = Shop::getShops();
        foreach ($shops as $key => $shop) {
            $id_lang_shop = Configuration::get('PS_LANG_DEFAULT', null, null, $shop['id_shop']);
            $lang = new Language($id_lang_shop);
            $shops[$key]['lang'] = $lang;
        }
        $this->context->smarty->assign(array(
            'shops' => $shops,
            'current_shop_id' => Shop::getContextShopID(),
            'uri_protocol' => $this->context->link->protocol_content
        ));
        return $this->display(__FILE__, 'blockshops.tpl');
    }

}
