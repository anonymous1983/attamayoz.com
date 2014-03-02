<?php

// Security
if (!defined('_PS_VERSION_'))
    exit;

// Checking compatibility with older PrestaShop and fixing it
if (!defined('_MYSQL_ENGINE_'))
    define('_MYSQL_ENGINE_', 'MyISAM');

// Loading Models
class Posmodeproduct extends Module {

    private $_html = '';
    private $_postErrors = array();

    public function __construct() {
        $this->name = 'posmodeproduct';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'posthemes';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');

        parent::__construct();

        $this->displayName = $this->l('Pos Swith Mode product ( list or grid) view');
        $this->description = $this->l('block config');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
        $this->admin_tpl_path = _PS_MODULE_DIR_ . $this->name . '/views/templates/admin/';
        if (!Configuration::get('POSMODEPRODUCT'))
            $this->warning = $this->l('No name provided');
    }

    public function install() {
        //Configuration::updateValue($this->name . '_limit_list', 4);
        //Configuration::updateValue($this->name . '_limit_grid', 3);
        return parent::install() &&
                $this->registerHook('displayHeader')
                &&
                $this->registerHook('top')
        ;
    }

    public function uninstall() {
        Configuration::deleteByName('POSTMODEPRODUCT');
        //Configuration::deleteByName($this->name . '_limit_list');
        //Configuration::deleteByName($this->name . '_limit_grid');
        // Uninstall Module
        if (!parent::uninstall())
            return false;
        // !$this->unregisterHook('actionObjectExampleDataAddAfter')
        return true;
    }

    //public function getContent() {
    //    $output = '<h2>' . $this->displayName . '</h2>';
    //    if (Tools::isSubmit('submitPm')) {
    //        if (!sizeof($this->_postErrors))
    //            $this->_postProcess();
    //        else {
    //            foreach ($this->_postErrors AS $err) {
    //                $this->_html .= '<div class="alert error">' . $err . '</div>';
    //            }
    //        }
    //    }
    //    return $output . $this->_displayForm();
    //}

    public function getSelectOptionsHtml($options = NULL, $name = NULL, $selected = NULL) {
        $html = "";
        $html .='<select name =' . $name . ' style="width:130px">';
        if (count($options) > 0) {
            foreach ($options as $key => $val) {
                if (trim($key) == trim($selected)) {
                    $html .='<option value=' . $key . ' selected="selected">' . $val . '</option>';
                } else {
                    $html .='<option value=' . $key . '>' . $val . '</option>';
                }
            }
        }
        $html .= '</select>';
        return $html;
    }

    private function _postProcess() {
        Configuration::updateValue($this->name . '_limit_list', Tools::getValue('limit_list'));
        Configuration::updateValue($this->name . '_limit_grid', Tools::getValue('limit_grid'));

        $this->_html .= '<div class="conf confirm">' . $this->l('Settings updated') . '</div>';
    }

    private function _displayForm() {
        $this->_html .= '
		<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
                  <fieldset>
                    <legend><img src="../img/admin/cog.gif" alt="" class="middle" />' . $this->l('Settings') . '</legend>';
        $this->_html .= '<label>' . $this->l('Limit Products in List view: ') . '</label>
                        <div class="margin-form">
                            <input type = "text"  name="limit_list" value =' . (Tools::getValue('limit_list') ? Tools::getValue('limit_list') : Configuration::get($this->name . '_limit_list')) . ' ></input>
                        </div>';
        $this->_html .= '<label>' . $this->l('Limit Products in  Grid view: ') . '</label>
                <div class="margin-form">
                    <input type = "text"  name="limit_grid" value =' . (Tools::getValue('limit_grid') ? Tools::getValue('limit_grid') : Configuration::get($this->name . '_limit_grid')) . ' ></input>
                </div>';

        $this->_html .='<input type="submit" name="submitPm" value="' . $this->l('Update') . '" class="button" />
                     </fieldset>
		</form>';
        return $this->_html;
    }

    public function hookDisplayHeader() {
        $this->context->controller->addCSS($this->_path . 'css/product_list.css');
    }

    public function hookTop() {
        $product_mode = NULL;
        $context = Context::getContext();
        if (!$context->cookie->__get('product_mode')) {
            $_GET['product_mode'] = 'grid';
            $context->cookie->__set('product_mode', 'grid');
            $product_mode = 'grid';
        } else {
            if (isset($_COOKIE['product_mode'])) {
                $context->cookie->__set('product_mode', $_COOKIE['product_mode']);
            } else {
                
            }
            $product_mode = $context->cookie->__get('product_mode');
            $_GET['product_mode'] = $product_mode;
        }
        $n = 0;
        if(isset($_GET['n'])) {
            $n = $_GET['n'];
        }
        
        if($n>0){
            $context->cookie->__set('limit_list',$n);
            $context->cookie->__set('limit_grid',$n);
        } else {
            $context->cookie->__set('limit_list',Configuration::get($this->name.'_limit_list'));
            $context->cookie->__set('limit_grid',Configuration::get($this->name.'_limit_grid'));
        }
        
        $this->smarty->assign('product_mode', $product_mode);
        return $this->display(__FILE__, 'swithmode.tpl');
    }

}