<?php
/**
 * $THEMEDESC
 * 
 * @version		$Id: file.php $Revision
 * @package		modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) Jan 2012 postheme.com <@emai:postheme@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
 */  
if( !class_exists('PosThemeInfo') ){ 
	class PosThemeInfo{
		
		/**
		 *
		 */
	public static function onGetInfo( $output=array(), $thminfo ){
		$output["patterns"] = array();
		$path = _PS_MODULE_DIR_.$thminfo->name."/views/templates/front/colortool/images/pattern";
			//echo $path;
		$regex = '/(\.gif)|(.jpg)|(.png)|(.bmp)$/i';
	
		if( !is_dir($path) ){ return $output; }
		
		$dk =  opendir ( $path );
		$files = array();
		while ( false !== ($filename = readdir ( $dk )) ) {
			if (preg_match ( $regex, $filename )) {
				$files[] = $filename;	
			}
		}  
	 	$output["patterns"] = $files;
	 
		return $output;
	}
	
	/**
	 *
	 */
	public static function onRenderForm( $html, $thmskins ){
		
		$baseURL =  _PS_BASE_URL_.__PS_BASE_URI__."modules/".$thmskins->name."/views/templates/front/colortool/images/pattern/";

		$pt = '
		
		<link rel="stylesheet" href="'._PS_BASE_URL_.__PS_BASE_URI__."modules/".$thmskins->name."/assets/admin/patterns.css".'" type="text/css" media="screen" charset="utf-8" />
		<script type="text/javascript" src="'._PS_BASE_URL_.__PS_BASE_URI__."modules/".$thmskins->name."/assets/admin/patterns.js".'"></script>
		<label class="lb_posbgpattern">'.$thmskins->l('Background Pattern').'</label>
			
		';
		$ps = $thmskins->themeInfo["patterns"];
	//	echo '<Pre>'.print_r( $ps,1); die;
		
		$pt .= '<div class="bgpattern" id="pnpartterns"> <input type="hidden" class="hdval" name="posbgpattern" value="'.Configuration::get('posbgpattern').'"/>';
		foreach( $ps as $p ){  
			$pt .='<a style="background:url(\''.$baseURL.$p.'\') center center;" onclick="return false;" href="#" title="'.$p.'" id="'.preg_replace("#\.\w+$#","",$p).'">
                </a>';
		}
                
		$pt  .= "</div>";
		
		$html .= $pt;
		return $html;
	}
	
	public static function onUpdateConfig(  ){
		$posbgpattern = (Tools::getValue('posbgpattern')); 
		Configuration::updateValue('posbgpattern', $posbgpattern);
	}
	
	public static function onProcessHookTop( $params ){
		$params["POS_BGPATTERN"] = Configuration::get('posbgpattern');
		return $params; 
	}
}	

}
?>