<?php
/*
 * 2013-2014 karar-consulting
 *
 *  @author karar-consulting SA <contact@karar-consulting.com>
 *  @copyright  2013-2014 karar-consulting SA
 *  @license    http://karar-consulting.comcarte de recharge
 *  International Registered Trademark & Property of karar-consulting SA
 */


class historyRechargeCardClass extends ObjectModel
{

	/** @var integer Object history_recharge_card id */
	public $id_history_recharge_card;
	
	/** @var integer Object history_recharge_card id recharge code */
	public $id_recharge_card;
	
	/** @var integer Object history_recharge_card id cutomer */
	public $id_customer;
        
        /** @var boolean Object history_recharge_card statuts */
	public $active = true;
        
        /** @var string Object history_recharge_card is deleted*/
	public $deleted;
        
        /** @var string Object history_recharge_card is archive*/
	public $archive;
        
       /** @var string Object history_recharge_card creation date */
	public $date_add;

	/** @var string Object history_recharge_card last modification date */
	public $date_upd;
        
        /** @var string Object history_recharge_card last modification date */
        public $this_recharge_card;
                
	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'history_recharge_card',
		'primary' => 'id_history_recharge_card',
		'multilang' => false,
		'fields' => array(
			'id_history_recharge_card' =>	array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
			'id_recharge_card' =>		array('type' => self::TYPE_INT, 'required' => true),
			'id_customer' =>		array('type' => self::TYPE_INT, 'required' => true),
                        'active' =>                     array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                        'deleted' =>            	array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                        'archive' =>                    array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
                        'date_add' =>                   array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
			'date_upd' =>                   array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
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
	* List of Tree Type
	*
	* @return list treeType
	*/
        public function getList() {
            $sql = 'SELECT *
                    FROM `' . _DB_PREFIX_ . $this->table .'`
                    WHERE `deleted` = 0 AND `archive` = 0';
            return Db::getInstance()->executeS($sql);
        }
        
}
