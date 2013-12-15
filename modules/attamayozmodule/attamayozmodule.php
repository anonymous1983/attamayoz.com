<?php

/*
 * 2013-2014 karar-consulting
 *
 *  @author karar-consulting SA <contact@karar-consulting.com>
 *  @copyright  2013-2014 karar-consulting SA
 *  @license    http://karar-consulting.com
 *  International Registered Trademark & Property of karar-consulting SA
 */


if (!defined('_PS_VERSION_'))
    exit;

include_once _PS_MODULE_DIR_ . 'attamayozmodule/treeTypeClass.php';

class AttamayozModule extends Module {

    public function __construct() {
        $this->name = 'attamayozmodule';
        $this->tab = 'others';
        $this->version = '1.0';
        $this->author = 'Karar Consulting';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Attamayoz');
        $this->description = $this->l('Management module points for users');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('ATT_BLOCK_TREE_TYPE_NAME'))
            $this->warning = $this->l('No name provided');
    }

    public function install() {
        if (!parent::install() ||
                !$this->registerHook('displayProductTab') ||
                !$this->registerHook('actionProductSave') ||
                !$this->registerHook('actionUpdateQuantity') ||
                !$this->registerHook('actionProductListOverride') ||
                //!$this->registerHook('actionProductAttributeUpdate') ||
                !$this->registerHook('displayAdminProductsExtra') ||
                //!$this->registerHook('productTab') ||
                //!$this->registerHook('productTabContent') ||
                !Configuration::updateValue('ATT_BLOCK_TREE_TYPE_NAME', NULL))
                return false;
        // Crreat Table Tree_type
        $sql = 'CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'tree_type (
                `id_tree_type` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(250) NOT NULL,
                `cost` float NOT NULL,
                `x_axis` int(11) NOT NULL,
                `y_axis` int(11) NOT NULL,
                `children` int(11) NOT NULL,  
                `active` tinyint(4) NOT NULL DEFAULT 1,
                `deleted` tinyint(4) NOT NULL DEFAULT 0,
                `archive` tinyint(4) NOT NULL DEFAULT 0,
                `date_add` datetime NOT NULL,
                `date_upd` datetime NOT NULL,
                PRIMARY KEY (`id_tree_type`))
                ENGINE=' . _MYSQL_ENGINE_ . ' default CHARSET=utf8';
        
        if (!Db::getInstance()->execute($sql))
                return false;
        
        
        
        if (Db::getInstance()->execute('SHOW COLUMNS FROM `' . _DB_PREFIX_ . 'product` LIKE \'id_tree_type\'')){
            if(Db::getInstance()->NumRows() == 0){
                // Update Table Product
                // Add id_tree_type
                $sql = 'ALTER TABLE  `' . _DB_PREFIX_ . 'product` ADD  `id_tree_type` INT NOT NULL';

                if (!Db::getInstance()->execute($sql))
                        return false;
            }
        }
        
        
        return true;
    }

    public function uninstall() {
        if (!parent::uninstall() ||
                //!Db::getInstance()->execute('DROP TABLE ' . _DB_PREFIX_ . 'tree_type') ||
                //!Db::getInstance()->execute('ALTER TABLE  ' . _DB_PREFIX_ . 'product DROP  id_tree_type') ||
                !Configuration::deleteByName('ATT_BLOCK_TREE_TYPE_NAME'))
            return false;
        return true;
    }

    public function getContent() {
        $output = null;
        // Tree Type
        // Get id Tree Type if exist
        $id_tree_type = (int) Tools::getValue('id_tree_type');
        // Save New Tree Type
        if (Tools::isSubmit('saveattamayozmodule')) {
            if ($id_tree_type = Tools::getValue('id_tree_type'))
                $tree_type = new treeTypeClass((int) $id_tree_type);
            else
                $tree_type = new treeTypeClass();
            $tree_type->children = $nbr = $tree_type->getTotalChildrens($_POST['x_axis'], $_POST['y_axis'], FALSE);
            $tree_type->copyFromPost();
            if ($tree_type->validateFields(FALSE)) {
                $tree_type->save();
            } else {
                $html .= '<div class="conf error">' . $this->l('An error occurred while attempting to save.') . '</div>';
            }
        }

        // Update and Add OR Delete OR List Tree Type    
        if (Tools::isSubmit('updateattamayozmodule') || Tools::isSubmit('addattamayozmodule')) {
            $treeType_action = (Tools::isSubmit('updateattamayozmodule')) ? 'Edit' : 'Add new';
            $helper = $this->treeType_initForm($treeType_action);
            if ($id_tree_type = Tools::getValue('id_tree_type')) {
                $tree_type = new treeTypeClass((int) $id_tree_type);
                $now = time();
                $this->fields_form[0]['form']['input'][] = array('type' => 'hidden', 'name' => 'id_tree_type');
                $helper->fields_value['title'] = $tree_type->title;
                $helper->fields_value['cost'] = $tree_type->cost;
                $helper->fields_value['x_axis'] = $tree_type->x_axis;
                $helper->fields_value['y_axis'] = $tree_type->y_axis;
                $helper->fields_value['date_upd'] = date('Y-m-d H:i:s', $now);
                $helper->fields_value['id_tree_type'] = (int) $id_tree_type;
            }
            return $html . $helper->generateForm($this->fields_form);
        } else if (Tools::isSubmit('deleteattamayozmodule')) {
            $tree_type = new treeTypeClass((int) $id_tree_type);
            $tree_type->delete();
            Tools::redirectAdmin(AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'));
        } else if (Tools::isSubmit('statusattamayozmodule')) {
            $tree_type = new treeTypeClass((int) $id_tree_type);

            $tree_type->active = !$tree_type->active;
            $tree_type->update();
            Tools::redirectAdmin(AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'));
        } else {
            $helper = $this->treeType_initList();
            $tree_type = new treeTypeClass();
            return $output . $helper->generateList($tree_type->getList(), $this->fields_list);
        }
    }

    protected function treeType_initList() {
        $this->fields_list = array(
            'id_tree_type' => array(
                'title' => $this->l('Id'),
                'width' => 40,
                'type' => 'text',
                'orderby' => false,
                'filter' => false,
                'search' => false
            ),
            'title' => array(
                'title' => $this->l('title'),
                'width' => 140,
                'type' => 'text'
            ),
            'x_axis' => array(
                'title' => $this->l('x'),
                'width' => 140,
                'type' => 'text'
            ),
            'y_axis' => array(
                'title' => $this->l('y'),
                'width' => 140,
                'type' => 'text'
            ),
            'cost' => array(
                'title' => $this->l('cost'),
                'width' => 140,
                'type' => 'text',
                'filter_key' => 'a!cost'
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
        $helper->identifier = 'id_tree_type';
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

    protected function treeType_initForm($treeType_action) {
        $default_lang = (int) Configuration::get('PS_LANG_DEFAULT');

        $this->fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('New Tree Type.'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Title:'),
                    'lang' => false,
                    'name' => 'title'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Cost:'),
                    'lang' => false,
                    'name' => 'cost'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('x_axis:'),
                    'lang' => false,
                    'name' => 'x_axis'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('y_axis:'),
                    'lang' => false,
                    'name' => 'y_axis'
                )
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'button'
            )
        );

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = 'attamayozmodule';
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
        $helper->title = $this->displayName . ' > ' . $this->l('Tree type') . ' > ' . $this->l($treeType_action);
        $helper->submit_action = 'saveattamayozmodule';
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
    
    public function hookDisplayProductTab($params)
    {
       return $this->display(__FILE__, 'tets.tpl'); 
    }
    
    public function hookActionProductSave($params)
    {
        $id_product = (int)$params['id_product'];
        $treetype = Tools::getValue("treetype");
        $tree_type_current_id = Tools::getValue("tree_type_current_id");
        
        if ($treetype && ($treetype != $tree_type_current_id)){
            $sql = '
                UPDATE `' . _DB_PREFIX_ . 'product` SET `id_tree_type` = '. $treetype .'
                WHERE `att_db_product`.`id_product` ='.$id_product;

            Db::getInstance()->execute($sql);
        }
        return true;
    }
    
    public function hookActionUpdateQuantity($params)
    {
        //die('hookActionUpdateQuantity');
        return true;
    }
    
    public function hookActionProductListOverride($params)
    {
        //die('hookActionProductListOverride');
        return true;
    }
    public function hookActionProductAttributeUpdate($params)
    {
        //die('hookActionProductAttributeUpdate');
        return true;
    }
    
    public function hookDisplayAdminProductsExtra($params) {
        global $smarty;
        
        $context = Context::getContext();
        $id_product = $context->controller->tpl_form_vars['id_product'];
        
        $tree_type = new treeTypeClass();
        $tree_type_list = $tree_type->getList();
        $tree_type_current_id = $tree_type->getIdTypeTreeForProduct($id_product);
        
        $this->context->smarty->assign(array(
                        'id_product' => $id_product,
                        'tree_type_list' => $tree_type_list,
                        'tree_type_current_id' => $tree_type_current_id[0]['id_tree_type'],
			'context' => $context
		));
        
        return $this->display(__FILE__, 'views/templates/admin/productTabTreeTypeContent.tpl');
    }
    
    
    
    //Method will be called while performing the "ProductTab" hook (tab buttons generation):
    public function hookProductTab($params)
    {
        global $smarty;
        //Call the template containing the HTML-code ?? our button
        return $this->display(__FILE__, 'views/admin/productTab.tpl');
    }
 
    public function hookProductTabContent($params)
    {
        global $smarty;
        //Transfer the new tab content into template via smatry
        //( it is optional as far as the content can be assigned directly in the template)
        $contant = 'Content New Tab';
        $smarty->assign('contant', $contant);
        // Call the template containing the HTML-code of our new tab content:
        return $this->display(__FILE__, 'views/admin/productTabContent.tpl');
    }
    
    

}

?>