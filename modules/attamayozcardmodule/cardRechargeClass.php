<?php
/*
 * 2013-2014 karar-consulting
 *
 *  @author karar-consulting SA <contact@karar-consulting.com>
 *  @copyright  2013-2014 karar-consulting SA
 *  @license    http://karar-consulting.comcarte de recharge
 *  International Registered Trademark & Property of karar-consulting SA
 */

include_once _PS_MODULE_DIR_ . 'attamayozcardmodule/cardRechargeClass.php';

class cardRechargeClass extends ObjectModel
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
                    WHERE `deleted` = 0 AND `archive` = 0 ORDER BY id_recharge_card DESC';
            return Db::getInstance()->executeS($sql);
        }
        
        /**
	* is use card
	*
	* @return object
	*/
        public function isCodeValid($code) {            
            return $this->isCodeUse($code);
        }
        
        
        /**
	* is use card
	*
	* @return object
	*/
        public function isCodeUse($code) {
            $sql = 'SELECT *
                    FROM `' . _DB_PREFIX_ . $this->table .'`
                    WHERE code = \''.$code.'\' AND `deleted` = 0 AND `archive` = 0 ';
            $result = Db::getInstance()->getRow($sql);
            $object = new stdClass();
            $object->numRows = (int)Db::getInstance()->numRows();
            if($object->numRows){
                $object->id_recharge_card   = $result['id_recharge_card'];
                $object->code               = $result['code'];
                $object->use                = (int)$result['use'];
                $object->date_use           = $result['date_use'];
                $object->active             = (int)$result['active'];
                $object->deleted            = (int)$result['deleted'];
                $object->archive            = (int)$result['archive'];            
                $object->date_add           = $result['date_add'];
                $object->date_upd           = $result['date_upd'];
            }
            return $object;
        }
        
        /**
	* set use
	*
	* @return object
	*/
        public function setUse($id_recharge_card, $id_customer, $use=1) {
            $now = time();
            $sql = 'UPDATE `' . _DB_PREFIX_ . $this->table .'` SET 
                    `use` = '. $use .',
                    `date_use` = \''. date('Y-m-d H:i:s', $now) .'\'
                    WHERE `id_recharge_card` ='.$id_recharge_card;
            $data = array(
                'id_recharge_card'   => $id_recharge_card,
                'id_customer' => $id_customer,
                'date_add' => date('Y-m-d H:i:s', $now),
                'date_upd' => date('Y-m-d H:i:s', $now)
            );
            if(!Db::getInstance()->execute($sql))
                return 'false 01';
            if(!Db::getInstance()->insert('history_recharge_card',$data))
                    return 'false 02';
            return true;            
        }
        
        
        
        /**
	* is use card
	*
	* @return object
	*/
        public function getListCardsForCustomer($id_customer, $id_lang)
	{
                $sql = 'SELECT *
                        FROM `' . _DB_PREFIX_ .'history_recharge_card` AS h, `' . _DB_PREFIX_ .'recharge_card` AS c
                        WHERE h.id_customer = \''.$id_customer.'\'
                        AND c.id_recharge_card = h.id_recharge_card';
            return Db::getInstance()->executeS($sql);
	}
        
}