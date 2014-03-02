<?php

// Security
if (!defined('_PS_VERSION_'))
    exit;

// Checking compatibility with older PrestaShop and fixing it
if (!defined('_MYSQL_ENGINE_'))
    define('_MYSQL_ENGINE_', 'MyISAM');

// Loading Models
require_once(_PS_MODULE_DIR_ . 'posstaticblocks/models/Staticblock.php');

class posstaticblocks extends Module {
    public  $hookAssign   = array();
    public $_staticModel =  "";
    public function __construct() {
        $this->name = 'posstaticblocks';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'posthemes';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');
        $this->hookAssign = array('rightcolumn','leftcolumn','home','top','footer','extraLeft');
        $this->_staticModel = new Staticblock();
        parent::__construct();

        $this->displayName = $this->l('Pos Staticblock');
        $this->description = $this->l('Manager Static blocks');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
        $this->admin_tpl_path = _PS_MODULE_DIR_ . $this->name . '/views/templates/admin/';
        if (!Configuration::get('POSSTATICBLOCKS'))
            $this->warning = $this->l('No name provided');
    }

    public function install() {

        // Install SQL
        include(dirname(__FILE__) . '/sql/install.php');
        foreach ($sql as $s)
            if (!Db::getInstance()->execute($s))
                return false;

          // Install Tabs
		if(!(int)Tab::getIdFromClassName('AdminPosMenu')) {
			$parent_tab = new Tab();
			// Need a foreach for the language
			$parent_tab->name[$this->context->language->id] = $this->l('PosExtentions');
			$parent_tab->class_name = 'AdminPosMenu';
			$parent_tab->id_parent = 0; // Home tab
			$parent_tab->module = $this->name;
			$parent_tab->add();
		}


        $tab = new Tab();
        // Need a foreach for the language
        $tab->name[$this->context->language->id] = $this->l('Manage Staticblocks');
        $tab->class_name = 'AdminPosstaticblocks';
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminPosMenu'); 
        $tab->module = $this->name;
        $tab->add();
        // Set some defaults
        return parent::install() &&
                $this->registerHook('top') &&
                $this->registerHook('leftColumn') &&
                $this->registerHook('rightColumn') &&
                $this->registerHook('home') &&
                $this->registerHook('footer') &&
                $this->registerHook('displayHeader')&&
                $this->registerHook('displayBackOfficeHeader');
    }

    public function uninstall() {

        Configuration::deleteByName('POSSTATICBLOCKS');

        // Uninstall Tabs
        //$tab = new Tab((int) Tab::getIdFromClassName('AdminPosstaticblocksMain'));
        //$tab->delete();
        $sql = array();
        include (dirname(__file__) . '/sql/uninstall_sql.php');
        foreach ($sql as $s) {
            if (!Db::getInstance()->Execute($s)) {
                return FALSE;
            }
        }
        $tab = new Tab((int) Tab::getIdFromClassName('AdminPosstaticblocks'));
        $tab->delete();

        // Uninstall Module
        if (!parent::uninstall())
            return false;
        return true;
    }
    
    
    public function hookTop($param) {
        $id_shop = (int)Context::getContext()->shop->id;
        $staticBlocks = $this->_staticModel->getStaticblockLists($id_shop,'top');
        if(count($staticBlocks)<1) return null;
        $this->smarty->assign(array(
            'staticblocks' => $staticBlocks,
        ));
       return $this->display(__FILE__, 'block.tpl');
    }
    
    public function hookLeftColumn($param) {
       $id_shop = (int)Context::getContext()->shop->id;
        $staticBlocks = $this->_staticModel->getStaticblockLists($id_shop,'leftColumn');
        if(count($staticBlocks)<1) return null;
        $this->smarty->assign(array(
            'staticblocks' => $staticBlocks,
        ));
       return $this->display(__FILE__, 'block.tpl');
    }
    
     public function hookRightColumn($param) { 
        $id_shop = (int)Context::getContext()->shop->id;
        $staticBlocks = $this->_staticModel->getStaticblockLists($id_shop,'rightColumn');
        $this->smarty->assign(array(
            'staticblocks' => $staticBlocks,
        ));
       return $this->display(__FILE__, 'block.tpl');
    }
    
    public function hookFooter($param) { 
        $id_shop = (int)Context::getContext()->shop->id;
        $staticBlocks = $this->_staticModel->getStaticblockLists($id_shop,'footer');
        if(count($staticBlocks)<1) return null;
        $this->smarty->assign(array(
            'staticblocks' => $staticBlocks,
        ));
       return $this->display(__FILE__, 'block.tpl');
    }
    
    public function hookHome($param) {
        $id_shop = (int)Context::getContext()->shop->id;
        $staticBlocks = $this->_staticModel->getStaticblockLists($id_shop,'home');
        if(count($staticBlocks)<1) return null;
        //if(is_array($staticBlocks))
        $this->smarty->assign(array(
            'staticblocks' => $staticBlocks,
        ));
       return $this->display(__FILE__, 'block.tpl');
    }
    
    public function hookDisplayBackOfficeHeader($params) {
        $this->context->controller->addJquery();
        $this->context->controller->addJS(($this->_path).'js/staticblock.js');
    }	
    
    
    public function getModulById($id_module) {
        return Db::getInstance()->getRow('
            SELECT m.*
            FROM `' . _DB_PREFIX_ . 'module` m
            JOIN `' . _DB_PREFIX_ . 'module_shop` ms ON (m.`id_module` = ms.`id_module` AND ms.`id_shop` = ' . (int) ($this->context->shop->id) . ')
            WHERE m.`id_module` = ' . $id_module);
    }

    public function getHooksByModuleId($id_module) {
        $module = self::getModulById($id_module);
        $moduleInstance = Module::getInstanceByName($module['name']);
        $hooks = array();
        if ($this->hookAssign)
            foreach ($this->hookAssign as $hook) {
                if (_PS_VERSION_ < "1.5") {
                    if (is_callable(array($moduleInstance, 'hook' . $hook))) {
                        $hooks[] = $hook;
                    }
                } else {
                    $retro_hook_name = Hook::getRetroHookName($hook);
                    if (is_callable(array($moduleInstance, 'hook' . $hook)) || is_callable(array($moduleInstance, 'hook' . $retro_hook_name))) {
                        $hooks[] = $retro_hook_name;
                    }
                }
            }
        $results = self::getHookByArrName($hooks);
        return $results;
    }

    public static function getHookByArrName($arrName) {
        $result = Db::getInstance()->ExecuteS('
		SELECT `id_hook`, `name`
		FROM `' . _DB_PREFIX_ . 'hook` 
		WHERE `name` IN (\'' . implode("','", $arrName) . '\')');
        return $result;
    }
  //$hooks = $this->getHooksByModuleId(10);
    public function getListModuleInstalled() {
        $mod = new posstaticblocks();
        $modules = $mod->getModulesInstalled(0);
        $arrayModule = array();
        foreach($modules as $key => $module) {
            if($module['active']==1) {
                $arrayModule[0] = array('id_module'=>0, 'name'=>'Chose Module');
                $arrayModule[$key] = $module;
            }
        }
        if ($arrayModule)
            return $arrayModule;
        return array();
    }

}