<?php

// Security
if (!defined('_PS_VERSION_'))
    exit;

// Checking compatibility with older PrestaShop and fixing it
if (!defined('_MYSQL_ENGINE_'))
    define('_MYSQL_ENGINE_', 'MyISAM');


class posthemeoptions extends Module {
    var $themeInfo = array();
    var $themePrefix = '';
    var $prefix = '';
    var $amounts = 4;
    var $base_config_url = '';
    var $overrideHooks  = array();
    
    public function __construct() {
        global $currentIndex;
        $this->name = 'posthemeoptions';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'posthemes';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');
        $this->currentIndex = $currentIndex;
        parent::__construct();

        $this->displayName = $this->l('Pos Themeoptions');
        $this->description = $this->l('Manage theme skins');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
        
        
        if(  file_exists(_PS_MODULE_DIR_.$this->name."/assets/theminfo.php") ){
                require( _PS_MODULE_DIR_.$this->name."/assets/theminfo.php" );
        }
        $this->themeInfo   = $this->getInfo();
        $this->themePrefix  = _THEME_NAME_;
        $this->prefix = 'poscp_';
        $this->amounts = 4;
        $this->base_config_url = $this->currentIndex . '&configure=' . $this->name . '&token=' . Tools::getValue('token');
        if (!Configuration::get('THEMEOPTIONS'))
            $this->warning = $this->l('No name provided');
    }

    public function install() {
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
        $tab->name[$this->context->language->id] = $this->l('Pos Themeoptions');
        $tab->class_name = 'AdminModules&configure=' . $this->name;
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
                $this->registerHook('displayHeader');
    }

    public function uninstall() {

        Configuration::deleteByName('THEMEOPTIONS');

        $tab = new Tab((int) Tab::getIdFromClassName('AdminModules&configure=' . $this->name));
        $tab->delete();

        // Uninstall Module
        if (!parent::uninstall())
            return false;
        return true;
    }
    
    function getContent()
	{
		$errors = array();
		$this->_html = '<h2>'.$this->displayName.'</h2>';
		
		if (Tools::isSubmit('submitUpdate')) {
			$posskin = (Tools::getValue('posskin')); 
			Configuration::updateValue('posskin', $posskin);
			$pospntool = (Tools::getValue('pospntool')); 
			Configuration::updateValue('pospntool', $pospntool);
                        
                        $poslinkcolor = (Tools::getValue('poslinkcolor'));
			Configuration::updateValue('poslinkcolor', $poslinkcolor);
                        $posbgcolor = (Tools::getValue('posbgcolor'));
			Configuration::updateValue('posbgcolor', $posbgcolor);
                        
			
			PosThemeInfo::onUpdateConfig();
			$forbidden = array('submitUpdate');
			
			foreach ($_POST AS $key => $value){
				if (!Validate::isCleanHtml($_POST[$key])){
					$this->_html .= $this->displayError($this->l('Invalid html field, javascript is forbidden'));
					$this->_displayForm();
					return $this->_html;
				}
			}
			$this->_html .= '<div class="conf confirm">'.$this->l('Settings updated successful').'</div>';
		}
		if (sizeof($errors)){
			foreach ($errors AS $err){
				$this->_html .= '<div class="alert error">'.$err.'</div>';
			}
		}
		$this->_displayForm();
		
		return $this->_html;
	}
        
        private function _displayForm()
	{
		global $cookie;
	 
		if( empty($this->themeInfo) ){
			$this->_html .= '	<fieldset style="width: 900px;"><legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->displayName.'</legend>'.
				$this->l("The Theme Configuration is not avariable, because may be you forgot set a theme from your site as default theme of front-office, Please try to check again")
			.'</fieldset';
			
			return ;
		}
		
		$skins = $this->themeInfo["skins"];
		$dskins = Configuration::get('posskin');
		
		$this->_html .= '<br />
		<form method="post" action="'.$this->base_config_url.'" enctype="multipart/form-data">
			<fieldset>
				<legend><img src="'.$this->_path.'logo.gif" alt="" title="" /> '.$this->displayName.'</legend>
                                <link rel="stylesheet" href="'.__PS_BASE_URI__.'modules/'.$this->name.'/assets/admin/jquery-ui.css" type="text/css" media="screen" charset="utf-8" />
				<script type="text/javascript">
					var iddiv = "'.(Tools::getValue('iddiv') ? Tools::getValue('iddiv') : 'base_setting').'";
					var base_url = "'.$this->base_config_url.'";
				</script>
				<script type="text/javascript" src="'.__PS_BASE_URI__.'modules/'.$this->name.'/assets/admin/form.js"></script>
                                <script type="text/javascript" src="'.__PS_BASE_URI__.'modules/'.$this->name.'/assets/option/jquery-1.6.2.min.js"></script>
                                <script type="text/javascript" src="'.__PS_BASE_URI__.'modules/'.$this->name.'/assets/option/mColorPicker.js"></script>
                                <script type="text/javascript">
                                    jQuery.noConflict();
                                    jQuery.fn.mColorPicker.defaults.imageFolder="'.__PS_BASE_URI__.'modules/'.$this->name.'/assets/option/images/";
                                </script>
				<script type="text/javascript">
                                    jQuery(function(){
                                         jQuery("#poslinkcolor").attr("data-hex", true).mColorPicker();
                                         jQuery("#posbgcolor").attr("data-hex", true).mColorPicker();
                                    })
                                </script>
				<div class="lof_config_wrrapper clearfix ui-tabs ui-widget ui-widget-content ui-corner-all" id="lof-pdf-tab">
					<div id="base_setting" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
						<label>'.$this->l('Theme Color').'</label>
						<div class="margin-form">
							<select name="posskin">';
							if(is_array($skins))
								foreach( $skins as $skin ){
									$this->_html .= '<option '.($skin==$dskins?'selected="selected"':"").' value="'.$skin.'">'.$this->l($skin).'</option>';
								}
							$this->_html .=	'</select>
						</div>	
						<label>'.$this->l('Panel Tool').'</label>	
						<div class="margin-form">
							<input type="radio" name="pospntool" id="pospntool_on" value="1" '.(Tools::getValue('pospntool', Configuration::get('pospntool')) ? 'checked="checked" ' : '').'/>
							<label class="t" for="pospntool_on"> <img src="../img/admin/enabled.gif" /></label>
							<input type="radio" name="pospntool" id="pospntool_off" value="0" '.(!Tools::getValue('pospntool', Configuration::get('pospntool')) ? 'checked="checked" ' : '').'/>
							<label class="t" for="pospntool_off"> <img src="../img/admin/disabled.gif" /></label>
						</div>
						';
					//$this->_html = PosThemeInfo::onRenderForm( $this->_html, $this );	
					$this->_html .= '<div class="clear pspace"></div>
						<div class="margin-form clear"><input type="submit" name="submitUpdate" value="'.$this->l('    Save    ').'" class="button" /></div>
					</div>
				</div>
			</fieldset>
		</form>';
	}
        
        public function getInfo(){
	
		$theme_dir = _THEME_NAME_;
		if( !file_exists( _PS_ALL_THEMES_DIR_.$theme_dir.'/config.xml') ){
			return ;
		}
				
		$info = simplexml_load_file( _PS_ALL_THEMES_DIR_.$theme_dir.'/config.xml' );
		if( !$info || !isset($info->name)|| !isset($info->positions) ){
			return null;
		}

		if( isset($info->author) && strtolower($info->author) == 'postheme' ){
 
			$p = (array)$info->positions;
			$output = array("skins"=>"", 'layouts' => '',"positions"=>$p["position"],"name"=>(string)$info->name );
			if( isset($info->skins) ){
				$tmp =  (array)$info->skins;
				$output["skins"] = $tmp["skin"];
			}
			if( isset($info->layouts) ){
				$tmp =  (array)$info->layouts; 
				$output["layouts"] = $tmp["layout"];
			}
			$output = PosThemeInfo::onGetInfo( $output, $this );
			return $output;
		}
	}
        
        public  function exec($hook_name, $hook_args = array(), $id_module = null)
	{	
		
		// Check arguments validity
		if (($id_module && !is_numeric($id_module)) || !Validate::isHookName($hook_name))
			throw new PrestaShopException('Invalid id_module or hook_name');

		// If no modules associated to hook_name or recompatible hook name, we stop the function
	
		if (!$module_list = Hook::getHookModuleExecList($hook_name))
			return '';
		
		// Check if hook exists
		if (!$id_hook = Hook::getIdByName($hook_name))
			return false;
	
		// Store list of executed hooks on this page
		Hook::$executed_hooks[$id_hook] = $hook_name;
			
		$live_edit = false;
		$context = Context::getContext();
		if (!isset($hook_args['cookie']) || !$hook_args['cookie'])
			$hook_args['cookie'] = $context->cookie;
		if (!isset($hook_args['cart']) || !$hook_args['cart'])
			$hook_args['cart'] = $context->cart;

		$retro_hook_name = Hook::getRetroHookName($hook_name);

		// Look on modules list
		$altern = 0;
		$output = '';
		foreach ($module_list as $array)
		{
			
			
			// Check errors
			if ($id_module && $id_module != $array['id_module'])
				continue;
			if (!($moduleInstance = Module::getInstanceByName($array['module'])))
				continue;
			
			
			// echo '<pre>'.print_r( $this->overrideHooks, 1 ); die;
			// Check permissions
			$exceptions = $moduleInstance->getExceptions($array['id_hook']);
			if (in_array(Dispatcher::getInstance()->getController(), $exceptions))
				continue;
			if (Validate::isLoadedObject($context->employee) && !$moduleInstance->getPermission('view', $context->employee))
				continue;

			// Check which / if method is callable
			
			$hook_callable = is_callable(array($moduleInstance, 'hook'.$hook_name));
			$ohook=$orhook="";
			$hook_retro_callable = is_callable(array($moduleInstance, 'hook'.$retro_hook_name));
			if( array_key_exists($moduleInstance->id,$this->overrideHooks) ){
				$ohook = Hook::getRetroHookName($this->overrideHooks[$moduleInstance->id]);
				$orhook = ($this->overrideHooks[$moduleInstance->id]);
				$hook_callable = is_callable(array($moduleInstance, 'hook'.$orhook));
				$hook_retro_callable = is_callable(array($moduleInstance, 'hook'.$ohook));
			}
					
			if (($hook_callable || $hook_retro_callable) && Module::preCall($moduleInstance->name))
			{
				$hook_args['altern'] = ++$altern;
				if( array_key_exists($moduleInstance->id,$this->overrideHooks) ){
					if ($hook_callable)
						$display = $moduleInstance->{'hook'.$orhook}($hook_args);
					else if ($hook_retro_callable)
						$display = $moduleInstance->{'hook'.$ohook}($hook_args);
				}else {
					// Call hook method
					if ($hook_callable)
						$display = $moduleInstance->{'hook'.$hook_name}($hook_args);
					else if ($hook_retro_callable)
						$display = $moduleInstance->{'hook'.$retro_hook_name}($hook_args);
				}
				// Live edit
				if ($array['live_edit'] && Tools::isSubmit('live_edit') && Tools::getValue('ad') && Tools::getValue('liveToken') == Tools::getAdminToken('AdminModulesPositions'.(int)Tab::getIdFromClassName('AdminModulesPositions').(int)Tools::getValue('id_employee')))
				{
					$live_edit = true;
					$output .= self::wrapLiveEdit($display, $moduleInstance, $array['id_hook']);
				}
				else
					$output .= $display;
			}

		}

		// Return html string
		return ($live_edit ? '<script type="text/javascript">hooks_list.push(\''.$hook_name.'\'); </script>
				<div id="'.$hook_name.'" class="dndHook" style="min-height:50px">' : '').$output.($live_edit ? '</div>' : '');
	}
        
        public static function wrapLiveEdit($display, $moduleInstance, $id_hook)
	{
		return '<script type="text/javascript"> modules_list.push(\''.Tools::safeOutput($moduleInstance->name).'\');</script>
				<div id="hook_'.(int)$id_hook.'_module_'.(int)$moduleInstance->id.'_moduleName_'.str_replace('_', '-', Tools::safeOutput($moduleInstance->name)).'"
				class="dndModule" style="border: 1px dotted red;'.(!strlen($display) ? 'height:50px;' : '').'">
				<span style="font-family: Georgia;font-size:13px;font-style:italic;">
				<img style="padding-right:5px;" src="'._MODULE_DIR_.Tools::safeOutput($moduleInstance->name).'/logo.gif">'
			 	.Tools::safeOutput($moduleInstance->displayName).'<span style="float:right">
			 	<a href="#" id="'.(int)$id_hook.'_'.(int)$moduleInstance->id.'" class="moveModule">
			 		<img src="'._PS_ADMIN_IMG_.'arrow_out.png"></a>
			 	<a href="#" id="'.(int)$id_hook.'_'.(int)$moduleInstance->id.'" class="unregisterHook">
			 		<img src="'._PS_ADMIN_IMG_.'delete.gif"></span></a>
			 	</span>'.$display.'</div>';
	}
        
        function hookHeader(){
		$output = '';
		
		global $cookie, $smarty;
		
		if( $this->themeInfo ){
			$skin         = Configuration::get('posskin');
                        $poslinkcolor = Configuration::get('poslinkcolor');
                        $posbgcolor   = Configuration::get('posbgcolor');
			$bgpattern    = Configuration::get('posbgpattern');
			$paneltool    = Tools::getValue('pospntool', Configuration::get('pospntool'));
                        
                        //$this->context->controller->addCss(  _PS_BASE_URL_.__PS_BASE_URI__."modules/".$this->name."/views/templates/front/colortool/css/posthemeoptions.css" );
//                        $this->context->controller->addJS(  _PS_BASE_URL_.__PS_BASE_URI__."js/posthem/pos.jq.slide.js" );
//                        $this->context->controller->addJS(  _PS_BASE_URL_.__PS_BASE_URI__."js/jquery/jquery-1.7.2.min.js" );
//                        $this->context->controller->addJS(  _PS_BASE_URL_.__PS_BASE_URI__."js/jquery/jquery-ui.will.be.removed.in.1.6.js" );
//                        $this->context->controller->addJS(  _PS_BASE_URL_.__PS_BASE_URI__."js/jquery/jquery.noConflict.php" );
//                        $this->context->controller->addJS(  _PS_BASE_URL_.__PS_BASE_URI__."modules/".$this->name."/assets/admin/jquery-ui-1.9.2.custom.js" );
			/* if enable user custom setting, the theme will use those configuration*/
			if( $paneltool ){
				//echo $_GET['bgpattern']; die;
//				$vars = array("skin"=>$skin,"layout"=>'',"bgpattern"=>$bgpattern);
//				if( isset($_GET["usercustom"]) && strtolower( $_GET['usercustom'] ) == "apply" ){
//					foreach( $vars as $key => $val ){
//						if( isset($_GET[$key]) ){  
//							$cookie->__set( "posu_".$key, $_GET[$key] );
//							$val =  $_GET[$key];
//						}
//					}
//					Tools::redirect( "index.php" );
//				}
//				if( isset($_GET["posaction"]) && $_GET["posaction"] == "reset" ){
//					foreach( $vars as $key => $val ){
//						$cookie->__set("posu_".$key, Configuration::get("pos"+$key));
//					}
//					Tools::redirect( "index.php" );	
//				} 
				//echo "<pre>".print_r($cookie,1); die;
//				if($vars){
//					foreach( $vars as $key => $val ){
//						if( $cookie->__get(  "posu_".$key ) ){
//							$$key = $cookie->__get(  "posu_".$key );	
//						}else {
//							$$key = $val;
//						}
//					}
//				}
                                $this->context->controller->addCss(  _PS_BASE_URL_.__PS_BASE_URI__."modules/".$this->name."/views/templates/front/colortool/css/colorpicker.css" );
                                $this->context->controller->addCss(  _PS_BASE_URL_.__PS_BASE_URI__."modules/".$this->name."/views/templates/front/colortool/css/pos.cltool.css" );
                                $this->context->controller->addJS(  _PS_BASE_URL_.__PS_BASE_URI__."modules/".$this->name."/assets/colortool/colorpicker.js" );
                                $this->context->controller->addJS(  _PS_BASE_URL_.__PS_BASE_URI__."modules/".$this->name."/assets/colortool/jquery.cookie.js" );
//                                
//				$this->context->controller->addJS(  _PS_BASE_URL_.__PS_BASE_URI__."js/jquery/jquery-1.7.2.min.js" );
//				$this->context->controller->addJS(  _PS_BASE_URL_.__PS_BASE_URI__."modules/".$this->name."/assets/admin/patterns.js" );
//				$this->context->controller->addCss(  _PS_BASE_URL_.__PS_BASE_URI__."modules/".$this->name."/assets/admin/patterns.css" );
			}
                        
			//echo $cookie->__get(  "posu_bgpattern" ); die;
			
			//
			// $sql = "SELECT *
				// FROM `"._DB_PREFIX_.'poshook` WHERE theme="'._THEME_NAME_.'" AND id_shop='.(int)($this->context->shop->id);	
			// $result = Db::getInstance()->executeS($sql);
			// if($result)
			// foreach( $result as $row ){
				// $this->overrideHooks[$row['id_module']] = $row['name_hook'];
			// }
			
			$ps = array(	
				'POS_SKIN_DEFAULT'      => $skin,
				'this_path'             => $this->_path,
				'POS_PANELTOOL'         => $paneltool,
                                'POS_PANELTOOL_TPL'     =>_PS_MODULE_DIR_.$this->name.'/views/templates/front/colortool.tpl',
				'POS_THEMEINFO'         => $this->themeInfo,
				'POS_THEMENAME'         => _THEME_NAME_,
                                'POS_MODULENAME'        => $this->name,
                                'POS_LINKCOLOR'         => $poslinkcolor,
                                'POS_BGCOLOR'           => $posbgcolor,
				'POS_PATTERN'           => $bgpattern.'.png',
				'POS_BGPATTERN'         => $bgpattern,
                                'PS_BASE_URL'         => _PS_BASE_URL_,
                                'PS_BASE_URI'         => __PS_BASE_URI__,
                                'HOOK_SLIDESHOW'        => $this->exec( 'displaySlideshow' ),
			 	'HOOK_TOPNAVIGATION'    => $this->exec('topNavigation'),
				'HOOK_PROMOTETOP'       => $this->exec( 'displayPromoteTop' ),
			 	'HOOK_HEADERRIGHT'      => $this->exec('displayHeaderRight'),
				'HOOK_BOTTOM'		=> $this->exec( 'displayBottom' ),
				'HOOK_CONTENTBOTTOM'    => $this->exec( 'displayContentBottom' ),
				'HOOK_FOOTNAV'          => $this->exec( 'displayFootNav' ),
			);
		 
			//$ps = PosThemeInfo::onProcessHookTop( $ps );
			
			$smarty->assign( $ps );

			
		}
		
		return $output;		
	}
}
