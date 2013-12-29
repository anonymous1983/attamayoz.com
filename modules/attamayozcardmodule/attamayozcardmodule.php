<?php

/*
 * 2013-2014 karar-consulting
 *
 *  @author karar-consulting SA <contact@karar-consulting.com>
 *  @copyright  2013-2014 karar-consulting SA
 *  @license    http://karar-consulting.comcarte de recharge
 *  International Registered Trademark & Property of karar-consulting SA
 */


if (!defined('_PS_VERSION_'))
    exit;

include_once _PS_MODULE_DIR_ . 'attamayozcardmodule/cardRechargeClass.php';

class AttamayozcardModule extends Module {

    public function __construct() {
        $this->name = 'attamayozcardmodule';
        $this->tab = 'others';
        $this->version = '1.0';
        $this->author = 'Karar Consulting';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Attamayoz Cr');
        $this->description = $this->l('Management module card recharge for users');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('ATT_BLOCK_CARD_RECHARGE_NAME'))
            $this->warning = $this->l('No name provided');
    }

    public function install() {
        if (!parent::install() ||    
            !$this->registerHook('displayHeader') ||
            !$this->registerHook('displayCustomerAccount'))
                return false;
        
        // Crreat Table Recharge_card
        $sql = 'CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'recharge_card (
                `id_recharge_card` int(11) NOT NULL AUTO_INCREMENT,
                `code` varchar(250) NOT NULL,
                `cost` float NOT NULL,
                `use` tinyint(4) NOT NULL DEFAULT 0,
                `date_use` datetime NOT NULL,
                `active` tinyint(4) NOT NULL DEFAULT 1,
                `deleted` tinyint(4) NOT NULL DEFAULT 0,
                `archive` tinyint(4) NOT NULL DEFAULT 0,
                `date_add` datetime NOT NULL,
                `date_upd` datetime NOT NULL,
                PRIMARY KEY (`id_recharge_card`))
                ENGINE=' . _MYSQL_ENGINE_ . ' default CHARSET=utf8';
        
        if (!Db::getInstance()->execute($sql))
                return false;
        
        // Crreat Table Recharge_card
        $sql = 'CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'history_recharge_card (
                `id_history_recharge_card` int(11) NOT NULL AUTO_INCREMENT,
                `id_recharge_card` int(11),
                `id_customer` int(11),
                `active` tinyint(4) NOT NULL DEFAULT 1,
                `deleted` tinyint(4) NOT NULL DEFAULT 0,
                `archive` tinyint(4) NOT NULL DEFAULT 0,
                `date_add` datetime NOT NULL,
                `date_upd` datetime NOT NULL,
                PRIMARY KEY (`id_history_recharge_card`))
                ENGINE=' . _MYSQL_ENGINE_ . ' default CHARSET=utf8';
        
        if (!Db::getInstance()->execute($sql))
                return false;       
        
        if (Db::getInstance()->execute('SHOW COLUMNS FROM `' . _DB_PREFIX_ . 'customer` LIKE \'points\'')){
            if(Db::getInstance()->NumRows() == 0){
                // Update Table Customer
                // Add total_balance
                $sql = 'ALTER TABLE  `' . _DB_PREFIX_ . 'customer` ADD  `points` FLOAT NOT NULL DEFAULT 0';

                if (!Db::getInstance()->execute($sql))
                        return false;
            }
        }
        
        if (Db::getInstance()->execute('SHOW COLUMNS FROM `' . _DB_PREFIX_ . 'customer` LIKE \'bonnus\'')){
            if(Db::getInstance()->NumRows() == 0){
                // Update Table Customer
                // Add total_balance
                $sql = 'ALTER TABLE  `' . _DB_PREFIX_ . 'customer` ADD  `bonnus` FLOAT NOT NULL DEFAULT 0';

                if (!Db::getInstance()->execute($sql))
                        return false;
            }
        }
        
        if (Db::getInstance()->execute('SHOW COLUMNS FROM `' . _DB_PREFIX_ . 'customer` LIKE \'total_recharge\'')){
            if(Db::getInstance()->NumRows() == 0){
                // Update Table Customer
                // Add total_balance
                $sql = 'ALTER TABLE  `' . _DB_PREFIX_ . 'customer` ADD  `total_recharge` FLOAT NOT NULL DEFAULT 0';

                if (!Db::getInstance()->execute($sql))
                        return false;
            }
        }
        
        if (Db::getInstance()->execute('SHOW COLUMNS FROM `' . _DB_PREFIX_ . 'customer` LIKE \'total_balance\'')){
            if(Db::getInstance()->NumRows() == 0){
                // Update Table Customer
                // Add total_balance
                $sql = 'ALTER TABLE  `' . _DB_PREFIX_ . 'customer` ADD  `total_balance` FLOAT NOT NULL DEFAULT 0';

                if (!Db::getInstance()->execute($sql))
                        return false;
            }
        }
        
        
        
        return true;
    }

    public function uninstall() {
        if (!parent::uninstall() ||
                !Configuration::deleteByName('ATT_BLOCK_CARD_RECHARGE_NAME'))
            return false;
        return true;
    }

    public function getContent() {
        $output = null;
        // Tree Type
        // Get id Tree Type if exist
        $id_recharge_card = (int) Tools::getValue('id_recharge_card');
        // Save New Tree Type
        if (Tools::isSubmit('saveattamayozcardmodule')) {
            if ($id_recharge_card = Tools::getValue('id_recharge_card'))
                $tree_type = new cardRechargeClass((int) $id_recharge_card);
            else
                $tree_type = new cardRechargeClass();
            $tree_type->copyFromPost();
            if ($tree_type->validateFields(FALSE)) {
                $tree_type->save();
            } else {
                $html .= '<div class="conf error">' . $this->l('An error occurred while attempting to save.') . '</div>';
            }
        }

        // Update and Add OR Delete OR List Tree Type    
        if (Tools::isSubmit('updateattamayozcardmodule') || Tools::isSubmit('addattamayozcardmodule')) {
            $action = (Tools::isSubmit('updateattamayozcardmodule')) ? 'Edit' : 'Add new';
            if ($id_recharge_card = Tools::getValue('id_recharge_card')) {
                $tree_type = new cardRechargeClass((int) $id_recharge_card);
                $disabled =  $tree_type->use;
            }
            $helper = $this->initForm($action, $disabled);
            if ($id_recharge_card = Tools::getValue('id_recharge_card')) {
                $tree_type = new cardRechargeClass((int) $id_recharge_card);
                $now = time();
                $this->fields_form[0]['form']['input'][] = array('type' => 'hidden', 'name' => 'id_recharge_card');
                $helper->fields_value['code'] = $tree_type->code;
                $helper->fields_value['cost'] = $tree_type->cost;
                $helper->fields_value['date_upd'] = date('Y-m-d H:i:s', $now);
                $helper->fields_value['id_recharge_card'] = (int) $id_recharge_card;
            }
            return $html . $helper->generateForm($this->fields_form);
        } else if (Tools::isSubmit('deleteattamayozcardmodule')) {
            $tree_type = new cardRechargeClass((int) $id_recharge_card);
            $tree_type->delete();
            Tools::redirectAdmin(AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'));
        } else if (Tools::isSubmit('statusattamayozcardmodule')) {
            $tree_type = new cardRechargeClass((int) $id_recharge_card);
            if(!$tree_type->use){
                $tree_type->active = !$tree_type->active;
                $tree_type->update();
            }
            Tools::redirectAdmin(AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'));
        } else {
            $helper = $this->initList();
            $tree_type = new cardRechargeClass();
            return $output . $helper->generateList($tree_type->getList(), $this->fields_list);
        }
    }

    protected function initList() {
        $this->fields_list = array(
            'id_recharge_card' => array(
                'title' => $this->l('Id'),
                'width' => 40,
                'type' => 'text',
                'orderby' => TRUE,
                'filter' => false,
                'search' => false
            ),
            'code' => array(
                'title' => $this->l('code'),
                'width' => 140,
                'type' => 'text'
            ),
            'cost' => array(
                'title' => $this->l('cost'),
                'width' => 140,
                'type' => 'text'
            ),
            'use' => array(
                'title' => $this->l('use'),
                'width' => 140,
                'type' => 'text'
            ),
            'date_use' => array(
                'title' => $this->l('date of use'),
                'width' => 130,
                'align' => 'center',
                'type' => 'datetime',
                'filter_key' => 'a!date_add'
            ),
        );
        $this->fields_list['active'] = array(
            'title' => $this->l('Status'),
            'width' => 70,
            'active' => 'status',
            'filter_key' => $alias . '!active',
            'align' => 'center',
            'type' => 'bool',
            'orderby' => false
        );
        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = true;
        $helper->identifier = 'id_recharge_card';
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = true;
        $helper->imageType = 'jpg';
        $helper->title = $this->displayName;
        $helper->table = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&add' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Add new')
        );
        return $helper;
    }

    protected function initForm($action, $disabled = 0) {
        $default_lang = (int) Configuration::get('PS_LANG_DEFAULT');
        
        //die('<pre>'.$this);
        if($disabled){
        $input = array(
                array(
                    'type' => 'text',
                    'disabled' =>  'disabled',
                    'label' => $this->l('Code :'),
                    'lang' => false,
                    'name' => 'code'
                ),
                array(
                    'type' => 'text',
                    'disabled' =>  'disabled',
                    'label' => $this->l('Cost :'),
                    'lang' => false,
                    'name' => 'cost'
                )
            );
        }else{
           $input = array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Code :'),
                    'lang' => false,
                    'name' => 'code'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Cost :'),
                    'lang' => false,
                    'name' => 'cost'
                )
            ); 
        }
        
        $this->fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('New Recharge Card'),
            ),
            'input' => $input,
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'button'
            )
        );

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = 'attamayozcardmodule';
        $helper->identifier = $this->identifier;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        foreach (Language::getLanguages(false) as $lang)
            $helper->languages[] = array(
                'id_lang' => $lang['id_lang'],
                'iso_code' => $lang['iso_code'],
                'name' => $lang['name'],
                'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
            );

        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;
        $helper->toolbar_scroll = true;
        $helper->title = $this->displayName . ' > ' . $this->l('Rechage card') . ' > ' . $this->l($action);
        $helper->submit_action = 'saveattamayozcardmodule';
        $helper->toolbar_btn = array(
            'save' =>
            array(
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            ),
            'back' =>
            array(
                'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            )
        );
        return $helper;
    }
    
    public function hookDisplayCustomerAccount($params)
    {
        $context = Context::getContext();
        $id_customer = $context->cart->id_customer;   
        $cardRechargeObject = new cardRechargeClass();
        $this->context->smarty->assign(array(
                        'in_footer'     => false,
                        'id_customer'   => $id_customer,
                        'total_balance' => $cardRechargeObject->getTotalBalance($id_customer),
                        'total_recharge' => $cardRechargeObject->getTotalRecharge($id_customer),
                        'bonnus' => $cardRechargeObject->getTotalBonnus($id_customer),
		));
	return $this->display(__FILE__, 'my-account.tpl');
    }
    
    public function hookDisplayHeader($params)
    {
            $this->context->controller->addCSS($this->_path.'views/css/attamayozcardmodule.css', 'all');
            return $this->display(__FILE__, 'attamayozcardmodule-header.tpl');
    }
        
    public function getProductTreeType($id_product){
        
        if (!Configuration::get('ATT_MOD_INSTALL'))
            return false;
        
        $sql = 'SELECT id_tree_type
                FROM `' . _DB_PREFIX_ . 'product`
                WHERE id_product = \''.$id_product.'\'';
        return Db::getInstance()->getValue($sql);
    }

}

?>