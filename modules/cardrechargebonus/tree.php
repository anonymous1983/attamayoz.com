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

class Tree extends ObjectModel
{
	/** @var integer Object tree id*/
	public $id_tree;
        
	public $id_customer;
	public $id_product;
        public $id_order;
        public $id_order_detail;
        public $id_tree_type;
        public $cost;
        public $tree_children;
        public $children;
        public $current_children;
        public $active;
        public $deleted;
        public $archive;
        public $date_add;
        public $date_upd;


	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'tree',
		'primary' => 'id_tree',
		'multilang' => false,
		'fields' => array(
			'id_customer' =>	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
                        'id_product' =>         array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
                        'id_order' =>           array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
                        'id_order_detail' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
                        'id_tree_type' =>	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'cost' =>		array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice', 'required' => true),
                        'tree_children' =>      array('type' => self::TYPE_STRING, 'validate' => 'isunsignedInt', 'required' => true),
                        'children' =>           array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
                        'current_children' =>   array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
                        'active' => 		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                        'children' =>		array('type' => self::TYPE_INT),
                        'deleted' =>		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                        'archive' =>		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                        'date_add' => 		array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
			'date_upd' => 		array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
		)
	);

	
}
