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

if (!defined('_PS_VERSION_'))
	exit;
include_once _PS_OVERRIDE_DIR_ . 'order/OrderState.php';

class CardRechargeBonus extends PaymentModule
{
	private $_html = '';
	private $_postErrors = array();
        private $_ps_os_card_recharge_bonus = 1;

        public $cardRechargeBonusName;
	public $address;
	public $extra_mail_vars;

	public function __construct()
	{
		$this->name = 'cardRechargeBonus';
		$this->tab = 'payments_gateways';
		$this->version = '2.3';
		$this->author = 'PrestaShop';
                $this->dependencies = array('attamayozcardmodule','attamayozmodule');

		$this->currencies = true;
		$this->currencies_mode = 'checkbox';

		$config = Configuration::getMultiple(array('CARTE_BONUS_CHOICE'));
		if (isset($config['CARTE_BONUS_CHOICE']))
			$this->cardRechargeBonusName = $config['CARTE_BONUS_CHOICE'];

		parent::__construct();

		$this->displayName = $this->l('Payments by card of recharge or bonus');
		$this->description = $this->l('This module allows you to accept payments by card of recharge or bonus.');
		$this->confirmUninstall = $this->l('Are you sure you want to delete these details?');
                
                
                $order_status = new OrderState();
                $order_status->invoice = 1;
                $order_status->send_email = 1;
                $order_status->module_name = $this->name;
                $order_status->color = 'LimeGreen';
                $order_status->paid = 1;
                $order_status->name = $this->l('Card Recharge or Bonus');
                $order_status->template = 'payment';
                
                
                
                // add order state cardRechargeBonus
                $sql = 'SELECT COUNT(  `module_name` ) FROM `' . _DB_PREFIX_ . 'order_state` WHERE `module_name` = \''.$this->name.'\'';
                if (!Db::getInstance()->getValue($sql)){
                    if($order_status->add($this->context->language->id))
                        $this->_ps_os_card_recharge_bonus = $result;
                }else{
                    $this->_ps_os_card_recharge_bonus = $order_status->getIdOrderState($this->name);
                }

		/*if ((!isset($this->chequeName) || !isset($this->address) || empty($this->chequeName) || empty($this->address)))
			$this->warning = $this->l('"To the order of" and "address" must be configured before using this module.');
		if (!count(Currency::checkPaymentCurrencies($this->id)))
			$this->warning = $this->l('No currency has been set for this module');
	
		$this->extra_mail_vars = array(
											'{carte_bonnusCARTE_BONUS_CHOICE}' => Configuration::get('CARTE_BONUS_CHOICE'),
											'{cheque_address}' => Configuration::get('CHEQUE_ADDRESS'),
											'{cheque_address_html}' => str_replace("\n", '<br />', Configuration::get('CHEQUE_ADDRESS'))
											);
                 * 
                 */
	}

	public function install()
	{
		if (!parent::install() || !$this->registerHook('displayHeader') || !$this->registerHook('payment') || !$this->registerHook('paymentReturn') || !Configuration::updateValue('PS_OS_CARD_RECHARGE_BONUS', $this->_ps_os_card_recharge_bonus))
			return false;
		return true;
	}

	public function uninstall()
	{
		if (!Configuration::deleteByName('CARTE_BONUS_CHOICE') || !parent::uninstall())
			return false;
		return true;
	}
        
        public function hookDisplayHeader($params)
        {
               $this->context->controller->addCSS($this->_path.'views/css/cardRechargeBonus.css', 'all');
        }

	public function hookPayment($params)
	{
		if (!$this->active)
			return;
		if (!$this->cardRechargeBonusCurrency($params['cart']))
			return;
                
                $cardRechargeClass = new cardRechargeClass();
                
		$this->smarty->assign(array(
			'this_path' => $this->_path,
			'this_path_crb' => $this->_path,
			'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/',
                        'total_balance' => $cardRechargeClass->getTotalBalance($params['cart']->id_customer)
		));
		return $this->display(__FILE__, 'payment.tpl');
	}

	public function hookPaymentReturn($params)
	{
		if (!$this->active)
			return;

		$state = $params['objOrder']->getCurrentState();
		if ($state == Configuration::get('PS_OS_CARD_RECHARGE_BONUS') || $state == Configuration::get('PS_OS_OUTOFSTOCK'))
		{
			$this->smarty->assign(array(
				'total_to_pay' => Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false),
				'status' => 'ok',
				'id_order' => $params['objOrder']->id
			));
			if (isset($params['objOrder']->reference) && !empty($params['objOrder']->reference))
				$this->smarty->assign('reference', $params['objOrder']->reference);
		}
		else
			$this->smarty->assign('status', 'failed');
                
		return $this->display(__FILE__, 'payment_return.tpl');
	}

	public function cardRechargeBonusCurrency($cart)
	{
		$currency_order = new Currency((int)($cart->id_currency));
		$currencies_module = $this->getCurrency((int)$cart->id_currency);

		if (is_array($currencies_module))
			foreach ($currencies_module as $currency_module)
				if ($currency_order->id == $currency_module['id_currency'])
					return true;
		return false;
	}
}
