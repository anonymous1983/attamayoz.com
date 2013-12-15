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

class RechargeCard extends ObjectModel
{
	/** @var integer Object recharge_card id */
	public $id_recharge_card;
	
	/** @var string Object recharge_card code of card */
	public $code;
	
	/** @var float Object recharge_card cost of card */
	public $cost;

	/** @var integer Object recharge_card statuts use card */
	public $use;
        
        /** @var integer Object recharge_card date use card */
	public $date_use;
        
        /** @var boolean Object recharge_card statuts */
	public $active = true;
        
        /** @var string Object recharge_card is deleted*/
	public $deleted;
        
        /** @var string Object recharge_card is archive*/
	public $archive;
        
       /** @var string Object recharge_card creation date */
	public $date_add;

	/** @var string Object recharge_card last modification date */
	public $date_upd;
        
        /** @var string Object recharge_card last modification date */
        public $this_recharge_card;

        /**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'recharge_card',
		'primary' => 'id_recharge_card',
		'multilang' => false,
		'fields' => array(
			'id_recharge_card' =>	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'code' =>		array('type' => self::TYPE_STRING, 'required' => true),
			'cost' =>		array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice', 'required' => true),
                        'use' =>                array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                        'date_use' =>           array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
                        'active' => 		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                        'deleted' =>		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                        'archive' =>		array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                        'date_add' => 		array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
			'date_upd' => 		array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
		)
	);

	/**
	* is use card
	*
	* @return object
	*/
        public static function getListCardsForCustomer($id_customer, $id_lang)
	{
		$sql = 'SELECT *
                    FROM `' . _DB_PREFIX_ . $this->table .'`
                    WHERE `deleted` = 0 AND `archive` = 0 ORDER BY id_recharge_card DESC';
            return Db::getInstance()->executeS($sql);
	}
}
