<?php
/*
 * 2013-2014 karar-consulting
 *
 *  @author karar-consulting SA <contact@karar-consulting.com>
 *  @copyright  2013-2014 karar-consulting SA
 *  @license    http://karar-consulting.comcarte de recharge
 *  International Registered Trademark & Property of karar-consulting SA
 */


/**
 * @since 1.5.0
 */

//include_once _PS_MODULE_DIR_ . 'attamayozcardmodule/historyRechargeCardClass.php';
class AttamayozcardmoduleActionsModuleFrontController extends ModuleFrontController
{
	/**
	 * @var int
	 */
	public $id_customer;
        
        /**
	 * @var string
	 */
        public $code;

	public function init()
	{
		parent::init();

		require_once($this->module->getLocalPath().'cardRechargeClass.php');
		$this->id_customer = (int)Tools::getValue('id_customer');
                $this->code = Tools::getValue('code');
	}

	public function postProcess()
	{
		if (Tools::getValue('process') == 'add')
			$this->processAdd();
		exit;
	}

	
	/**
	 * Add or assign recharge card for customer
	 */
	public function processAdd()
	{
		//$product = new Product($this->id_customer);
                $cardRechargeClass = new cardRechargeClass();
                $cardRecharge = $cardRechargeClass->isCodeUse($this->code);
                
                if($cardRecharge->numRows && !$cardRecharge->use){
                    if($cardRechargeClass->setUse($cardRecharge->id_recharge_card, $this->id_customer))
                        die(json_encode($cardRecharge));
                    else
                        die('0');
                }
                    die('0');
	}
}