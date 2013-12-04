<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class treeTypeClass extends ObjectModel
{
	/** @var integer Object tree_type id*/
	public $id_tree_type;
	
	/** @var string Object tree_type title of tree type*/
	public $title;
	
	/** @var float Object tree_type value of cost sponsorship*/
	public $cost;

	/** @var integer Object tree_type length of x*/
	public $x_axis;
        
        /** @var integer Object tree_type  length of y*/
	public $y_axis;
        
        /** @var boolean Object tree_type statuts */
	public $active = true;
        
        /** @var integer Object tree_type number of children*/
	public $children;
        
        /** @var string Object tree_type is deleted*/
	public $deleted;
        
        /** @var string Object tree_type is $archive*/
	public $archive;
        
       /** @var string Object tree_type creation date */
	public $date_add;

	/** @var string Object tree_type last modification date */
	public $date_upd;


	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'tree_type',
		'primary' => 'id_tree_type',
		'multilang' => false,
		'fields' => array(
			'id_tree_type' =>	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'title' =>		array('type' => self::TYPE_STRING, 'required' => true),
			'cost' =>		array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice', 'required' => true),
                        'x_axis' =>             array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
                        'y_axis' =>             array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
                        'active' => 		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                        'children' =>		array('type' => self::TYPE_INT),
                        'deleted' =>		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                        'archive' =>		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                        'date_add' => 		array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
			'date_upd' => 		array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
		)
	);

	public function copyFromPost()
	{
		/* Classical fields */
		foreach ($_POST AS $key => $value)
			if (key_exists($key, $this) AND $key != 'id_'.$this->table)
				$this->{$key} = $value;
                                /* Multilingual fields */
                                
		if (sizeof($this->fieldsValidateLang))
		{
			$languages = Language::getLanguages(false);
			foreach ($languages AS $language)
				foreach ($this->fieldsValidateLang AS $field => $validation)
					if (isset($_POST[$field.'_'.(int)($language['id_lang'])]))
						$this->{$field}[(int)($language['id_lang'])] = $_POST[$field.'_'.(int)($language['id_lang'])];
		}
		
	}
        
        /**
	* Total Children
	*
	* @param integer $profondeurX
	* @param integer $profondeurY
	* @param integer $withParent (optional)
	* @return integer totalChildre
	*/
	public function getTotalChildrens($profondeurX, $profondeurY, $withParent = true){
		$withParent = ($withParent) ? 0 : 1;
		$s = pow($profondeurX, $profondeurY);
		while ($profondeurY-- > $withParent):
			$s += pow($profondeurX, $profondeurY);
		endwhile;
		return $s;
	}
}
